<?php

namespace app\modules\Codnitive\SepMicro\models;

use Yii;
use app\modules\Codnitive\Core\models\ActiveRecord;
// use app\modules\Codnitive\Core\helpers\Rules;
// use app\modules\Codnitive\Core\helpers\Tools;

class Transaction extends ActiveRecord
{
    protected $_parentObjectField = 'order_id';

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{saman_sep_micro_transaction}}';
    }

    public function rules()
    {
        $rules = [
            [['order_id', 'state_code', 'state', 'ref_num', 'trance_no', 'verifiaction_result', 'wallet_transaction_id'], 'safe'],
            [['state_code', 'state'], 'required']
        ];
        return $rules;
    }

    public function setOrderId(int $orderId): self
    {
        $this->_parentObjectId = $orderId;
        return $this;
    }

    public function loadByRefNum(string $refNum, int $orderId)
    {
        if (empty($refNum)) {
            return $this;
        }
        $row = $this->loadOne(0, ['ref_num' => $refNum]);
        if (!empty($row['order_id']) && $row['order_id'] !== $orderId) {
            return false;
        }
        return $row;
    }

}
