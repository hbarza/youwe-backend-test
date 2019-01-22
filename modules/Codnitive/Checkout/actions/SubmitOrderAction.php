<?php

namespace app\modules\Codnitive\Checkout\actions;

use Yii;
use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Sales\models\Order;
// use app\modules\Codnitive\Checkout\models\CartItem;
use app\modules\Codnitive\Adyen\models\Api as AdyenApi;
use app\modules\Codnitive\Sales\models\System\Source\OrderStatus;

class SubmitOrderAction extends Action
{
    public function run()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $checkout  = $request->post('Checkout');
            if (!empty($errorMessage = $this->_validateForm($checkout))) {
                return $this->_backToCart("Please check these errors:<br>$errorMessage");
            }

            $cart      = Yii::$app->cart;
            $qtyResult = $cart->checkItemsAvailability()
                ->checkItemsAvailabilityErrors();
            if (!$qtyResult) {
                return $this->controller->redirect(['/checkout/cart']);
            }

            $order    = new Order;
            $orderObj = $order->saveOrder($checkout, $cart);
            $orderObj->setAttributes($orderObj->jsonDecodeFields($orderObj));
            if ($orderObj) {
                try {
                    $paymentResult = (new AdyenApi)->authorise(
                        $checkout['adyen_encrypted_data'], 
                        $orderObj
                    );
                }
                catch (\Exception $e) {
                    return $this->_backToCart($e->getMessage());
                }
                $orderObj->setAttribute('payment_info', $paymentResult);
                
                if (isset($paymentResult['refusalReason'])) {
                    $orderObj->setAttribute(
                        'status', 
                        Tools::getOptionIdByValue('Sales', 'OrderStatus', OrderStatus::CANCELED));
                    $orderObj->save();
                    $errorMessage = "Payment Error:
                        <br>{$paymentResult['resultCode']}: {$paymentResult['refusalReason']}";
                    return $this->_backToCart($errorMessage);
                }
                $orderObj->setAttribute(
                    'status', 
                    Tools::getOptionIdByValue('Sales', 'OrderStatus', OrderStatus::COMPLETED));
                $orderObj->save();
                $cart->clear();
                return $this->controller->redirect([
                    '/checkout/cart/success', 
                    'order_id' => $order->id
                ]);
            }
            Yii::$app->session->set('billing_data', $checkout['billing']);
        }

        if (!isset($orderObj)) {
            $errorMessage ='An error occurred on order submission.';
        }
        return $this->_backToCart($errorMessage);
    }

    private function _validateForm($data)
    {
        $errorMessage = '';
        $billingRequiredFields = [
            'email', 'fullname', 'address', 'location'
        ];
        $requiredeFields = [
            'payment_method', 'adyen_encrypted_data'
        ];
        $validator = new \yii\validators\EmailValidator();

        if (!$validator->validate($data['billing']['email'], $error)) {
            $errorMessage .= "Email is not a valid email address<br>";
        }
        foreach ($billingRequiredFields as $field) {
            if (!isset($data['billing'][$field]) || empty($data['billing'][$field])) {
                $errorMessage .= ucfirst($field).' is required<br>';
            }
        }
        foreach ($requiredeFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $errorMessage .= ucfirst($field).' is required<br>';
            }
        }
        return rtrim($errorMessage, '<br>');
    }

    protected function _backToCart($messge, $msgType = 'danger')
    {
        $this->setFlash($msgType, $messge);
        return $this->controller->redirect(['/checkout/cart']);
    }
}
