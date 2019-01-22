<?php 

namespace app\modules\Codnitive\Wallet\blocks;

use app\modules\Codnitive\Core\blocks\Template;

class CreditForm extends Template
{
    public function getGrandTotal()
    {
        return isset(app()->session->get('payment_params')['grand_total'])
            ? app()->session->get('payment_params')['grand_total']
            : 0;
    }

    public function getAutoFillCreditFieldValue()
    {
        $userCredit = app()->getUser()->identity->credit_amount;
        return (int) min((float) $this->getGrandTotal(), (float) $userCredit);
    }
}
