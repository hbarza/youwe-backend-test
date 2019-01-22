<?php

namespace app\modules\Codnitive\Wallet\models;

use app\modules\Codnitive\Core\models\ActiveRecord;
use app\modules\Codnitive\Wallet\models\Account\Transaction\Gift;

class Transaction extends ActiveRecord
{
    protected $_parentObjectField = 'user_id';

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{user_wallet_credit_transaction}}';
    }

    public function rules()
    {
        $rules = [
            [['user_id', 'change_amount', 'new_amount', 'description', 'trasaction_date'], 'safe'],
            [['user_id', 'change_amount', 'trasaction_date'], 'required']
        ];
        return $rules;
    }

    public function setUserId(int $userId): self
    {
        $this->_parentObjectId = $userId;
        return $this;
    }

    public function loadPendingTransaction(int $transactionId): self
    {
        $object = $this->loadOne(0, [
            'id' => $transactionId,
            'new_amount' => null, 
            'user_id' => $this->_parentObjectId
        ]);
        return $object;
    }

    public function addChargeRequest(float $amount, string $gateway): self
    {
        $data = [
            'user_id' => $this->_parentObjectId,
            'change_amount' => $amount,
            'description' => __('wallet', 'Charge request added'),
            'trasaction_date' => $this->_getTimestamp()
        ];
        $this->setAttributes($data);
        $this->save();
        return $this;
    }

    public function addCredit(float $amount): float
    {
        $currentCredit = (float) tools()->getUser()->identity->credit_amount;
        $newCreditAmount = $currentCredit + $amount;
        $this->_updateUserCredit($newCreditAmount);
        return $newCreditAmount;
    }

    public function minusCredit(float $amount): float
    {
        $newCreditAmount = $this->addCredit(-1 * abs($amount));
        return $newCreditAmount;
    }

    public function addCharge(): self
    {
        $currentCredit = (float) tools()->getUser()->identity->credit_amount;
        $giftCredit = (new Gift)->getGiftCreditAmount($this->change_amount);
        $newCreditAmount = $currentCredit + $this->change_amount + $giftCredit;
        $this->_updateUserCredit($newCreditAmount);
        $this->new_amount = $newCreditAmount;
        $this->description = __('wallet', 'Success Credit Charge');
        $this->save();
        return $this;
    }

    public function useCredit(float $requestedCreditAmount, int $referenceNumber): self
    {
        $currentCredit = (float) tools()->getUser()->identity->credit_amount;
        $newCreditAmount = $currentCredit - $requestedCreditAmount;
        $this->_updateUserCredit($newCreditAmount);
        // app()->getModule('wallet');
        $data = [
            'user_id' => tools()->getUser()->id,
            'change_amount' => -$requestedCreditAmount,
            'new_amount' => $newCreditAmount,
            'description' => __('wallet', 'Buying in order# {order_number}', ['order_number' => $referenceNumber]),
            'trasaction_date' => $this->_getTimestamp()
        ];
        $this->setAttributes($data);
        $this->save();
        return $this;
    }

    public function revertCredit(int $transactionId, string $orderNumber): self
    {
        $transaction = $this->loadOne($transactionId);
        $currentCredit = (float) tools()->getUser()->identity->credit_amount;
        $newCreditAmount = $currentCredit - $transaction->change_amount;
        $this->_updateUserCredit($newCreditAmount);

        $data = [
            'user_id' => $transaction->user_id,
            'change_amount' => -$transaction->change_amount,
            'new_amount' => $newCreditAmount,
            'description' => __('wallet', 'Revert transaction order# {order_number}', ['order_number' => $orderNumber]),
            'trasaction_date' => $this->_getTimestamp()
        ];
        $this->setAttributes($data);
        $this->save();
        return $this;
    }

    public function refundCredit(float $amount, string $orderNumber, string $ticketId): self
    {
        $newCreditAmount = $this->addCredit($amount);
        $data = [
            'user_id' => tools()->getUser()->id,
            'change_amount' => $amount,
            'new_amount' => $newCreditAmount,
            'description' => __('template', 'Refund for ticket ID {ticket_id} from order# {order_number}', 
                ['ticket_id' => $ticketId, 'order_number' => $orderNumber]
            ),
            'trasaction_date' => $this->_getTimestamp()
        ];
        $this->setAttributes($data);
        $this->save();
        return $this;
    }

    private function _updateUserCredit(float $newCreditAmount): void
    {
        tools()->getUser()->identity->credit_amount = $newCreditAmount;
        tools()->getUser()->identity->save();
    }

    protected function _getTimestamp(): string
    {
        return (new \DateTime())->format('Y-m-d H:i:s');
    }

}
