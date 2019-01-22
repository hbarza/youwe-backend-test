<?php 

namespace app\modules\Codnitive\SepMicro\models;

use app\modules\Codnitive\SepMicro\models\Transaction;
// use app\modules\Codnitive\Sales\models\Order\PaymentInfo;
use app\modules\Codnitive\Sales\models\Order;

class Gateway extends \app\modules\Codnitive\Checkout\models\GatewayAbstract 
    implements \app\modules\Codnitive\Checkout\models\GatewayInterface
{
    public const PAYMENT_METHOD = 'SepMicro';
    protected $_apiConnector;

    public function __construct(Connector $apiConnector)
    {
        app()->getModule(\app\modules\Codnitive\SepMicro\Module::MODULE_ID);
        $this->_apiConnector = $apiConnector;
    }

    public function getFormModel(array $paymentParams): RedirectForm
    {
        $formModel = new RedirectForm;
        $formModel->setAttributes([
            // 'Amount' => (int) round($paymentParams['grand_total']),
            // 'MID' => \app\modules\Codnitive\SepMicro\models\Connector::MERCHANT_CODE,
            // 'ResNum' => $paymentParams['order_number'],
            'Token' => $paymentParams['token'],
            'RedirectURL' => $paymentParams['callback_address'],
        ]);
        return $formModel;
    }

    public function getToken(int $grandTotal, string $orderId)
    {
        return $this->_apiConnector->RequestToken($grandTotal, $orderId);
    }

    public function setupPayment(Order $order, array $params = [], string $callBackRoute = '', float $payableAmount = 0.0): array
    {
        $payableAmount = $payableAmount ?: (float) $order->grand_total;
        $token = $this->getToken($payableAmount, $order->id);
        $this->_updateSession($payableAmount, $token, $callBackRoute);

        if ($order && $token && strlen($token) > 3) {
            $order->setOrderPendingPayment();
            return [
                'status'   => true,
                'message'  => '',
                'redirect' => $this->getRedirectUrl()
            ];
        }
        return [
            'status'   => false,
            'message'  => 'We couldn\'t connect to gateway',
            'redirect' => ''
        ];
    }

    private function _updateSession(float $grandTotal, string $token, string $callBackRoute): void
    {
        $payment_params = app()->session->get('payment_params');
        $payment_params = \yii\helpers\ArrayHelper::merge($payment_params, [
            // 'grand_total' => $grandTotal,
            'payment_method' => self::PAYMENT_METHOD,
            'callback_address' => tools()->getUrl($callBackRoute, [], false, true),
            'token' => $token
        ]);
        app()->session->set('payment_params', $payment_params);
    }

    public function finalizeTransaction(array $params): array
    {
        if (!isset($params['StateCode'])) {
            return [
                'status' => false,
                'message' => __('sepmicro', 'Invalid request data.')
            ];
        }

        $transaction = (new Transaction)->loadByRefNum($params['RefNum'], $params['ResNum']);
        if (!$transaction) {
            return [
                'status' => false,
                'message' => __('sepmicro', 'Invalid reference number.')
            ];
        }
        $transaction->setAttributes($this->_mapData($params));
        if (!$transaction->validate()) {
            return [
                'status' => false,
                'message' => __('sepmicro', implode(', ', $transaction->errors))
            ];
        }
        $transaction->save();

        $successPaymentCondition = '0' === $params['StateCode'] && 'OK' === $params['State'];
        if (!$successPaymentCondition) {
            return [
                'status' => false,
                'message' => __('sepmicro', $params['State'] ?? 'An error accourd on your payment.')
            ];
        }
        
        return $this->verifyTransaction($transaction, $params);
    }

    public function verifyTransaction(Transaction $transaction, array $params)
    {
        $try = 3;
        $verified = false;
        for ($i = 0; $i <= $try; $i++) {
            if ($verified) {
                break;
            }
            sleep($i * 5);

            $verificationResult = $this->_apiConnector->VerifyTransaction($params['RefNum']);
            if (is_numeric($verificationResult)) {
                $verified = true;
                $transaction->verifiaction_result = $verificationResult;
                $transaction->save();

                if ($verificationResult < 0) {
                    return [
                        'status' => false,
                        'message' => tools()->getOptionValue('SepMicro', 'VerificationError', $verificationResult)
                    ];
                }

                if (floatval($params['Amount']) !== $verificationResult) {
                    $revertResult = $this->_apiConnector->reverseTransaction($params['RefNum']);
                    $message = 'Saman Gateway couldn\'t verify your payment, transaction reverted.';
                    if ($revertResult !== floatval(1)) {
                        $message  = 'Saman Gateway couldn\'t verify your payment, revert transaction was not successful.';
                        $verified = false;
                    }
                    return [
                        'status' => false,
                        'message' => __('sepmicro', $message)
                    ];
                }
            }
        }

        return [
            'status'  => true,
            'message' => __('sepmicro', 'Transaion was successful.')
        ];
    }

    public function revertTransaction(string $refNumb): array
    {
        $revertResult = $this->_apiConnector->reverseTransaction($refNumb);
        $status  = true;
        $message = 'Your payment transaction reverted.';
        if ($revertResult !== floatval(1)) {
            $status  = false;
            $message = 'Revert transaction request was sent to bank but was not successful.';
        }
        return [
            'status' => $status,
            'message' => __('sepmicro', $message)
        ];
    }

    public function refundAmount(float $refundAmount, string $orderNumber, string $ticketId): bool
    {
        return true;
    }

    // public function getPaymentInfo(array $params): PaymentInfo
    // {
    //     $paymentInfo = new PaymentInfo;
    //     $paymentInfo->transaction_number = $params['RefNum'];
    //     $paymentInfo->trace_number = $params['TRACENO'];
    //     return $paymentInfo;
    // }

    private function _mapData(array $params)
    {
        $data = [
            'state_code' => $params['StateCode'],
            'state' => $params['State'],
            'ref_num' => empty($params['RefNum']) ? null : $params['RefNum'],
            'trance_no' => $params['TRACENO'],
        ];
        if (isset($params['wlt_id'])) {
            $data['wallet_transaction_id'] = $params['wlt_id'];
            unset($params['ResNum']);
        }
        if (isset($params['ResNum'])) {
            $data['order_id'] = $params['ResNum'];
        }
        return $data;
    }

    public function getRedirectUrl(): string
    {
        return tools()->getUrl('sepmicro/gateway/redirect');
    }

    public function getTitle(): string
    {
        return __('sepmicro', 'Saman Gateway');
    }
}

