<?php

namespace app\modules\Codnitive\Wallet\models\Account\Transaction\Grid;

use yii\db\ActiveQuery;
use app\modules\Codnitive\Wallet\models\Transaction;
use app\modules\Codnitive\Calendar\models\Persian;

class Filter extends Transaction
{
    /**
     * Requried to use in filters
     */
    use \app\modules\Codnitive\Core\models\Grid\FilterTrait;

    protected $_searchParams = [];

    public function rules()
    {
        $rules = [
            [['id', 'change_amount', 'new_amount', 'trasaction_date', 'description'], 'safe'],
        ];
        return $rules;
    }

    protected function _getObjectFormattedParam($param, $paramValue)
    {
        $formattedValue = $paramValue;
        switch ($param) {
            case 'trasaction_date':
                $dateParts = explode(' ', tools()->getFormatedDate($paramValue, 'Y-m-d H:i'));
                $formattedValue = str_replace('-', '/', (new Persian)->getDate($dateParts[0])) . ' ' . $dateParts[1];
                break;
            case 'id':
                $formattedValue = 'WLT-'.$paramValue;
                break;

        }
        return $formattedValue;
    }
}
