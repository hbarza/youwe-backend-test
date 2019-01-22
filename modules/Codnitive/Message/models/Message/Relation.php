<?php

namespace app\modules\Codnitive\Message\models\Message;

use yii\db\Expression;
use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Sales\models\Order;

class Relation extends \app\modules\Codnitive\Core\models\ActiveRecord
{
    public $message;
    public $order_number;
    public $relation_id;
    public $created_at;
    public $fullname;

    protected $_savedMessageRelations = [];

    public static function tableName()
    {
       return '{{order_message_relation}}';
    }

    public function rules()
    {
       $rules = [
           [['order_id', 'entity_id', 'entity_type', 'customer_id', 'message_id',
                'new'
            ], 'safe']
       ];
       return $rules;
    }

    public function afterFind()
    {
        $this->order_number = (new Order)->getOrderNumber(true, $this->order_id);
    }

    public function loadOne(int $id, array $where = [])
    {
        $relation = parent::loadOne($id, $where);
        if ($relation->new) {
            $relation->setData(['new' => 0])->save();
        }
        return $relation;
    }

    public function saveMessageRelation($item, $orderId)
    {
        $entityId    = (int) $item->getProduct()->entity_id;
        $entityType  = (int) $item->getProduct()->entity_type;
        $relationKey = "$entityId-$entityType";
        if (in_array($relationKey, $this->_savedMessageRelations)) {
            return $this;
        }
        $customerId = (int) Tools::getUser()->getId();
        $condition = ['and',
            ['=', 'entity_id',   $entityId],
            ['=', 'entity_type', $entityType],
            ['=', 'customer_id', $customerId],
        ];
        if ($this->loadOne(0, $condition)->entity_id) {
            return $this;
        }
        $data = [
            'order_id'    => $orderId,
            'entity_id'   => $entityId,
            'entity_type' => $entityType,
            'customer_id' => $customerId,
            'new'         => 1
        ];
        $this->_savedMessageRelations[] = $relationKey;
        return $this->setData($data)->save();
    }

    public function addMessageToRelation(int $entityId, int $entityType, int $messageId)
    {
        $condition = ['and',
            ['=', 'entity_id',   $entityId],
            ['=', 'entity_type', $entityType],
            // ['in', 'id', $ids],
        ];
        $query  = "IF (message_id IS NULL, '$messageId', concat(message_id, ',$messageId'))";
        return static::updateAll([
            'message_id' => new Expression($query),
            'new'        => 1
        ], $condition);
    }

    public function hasNewMessage()
    {
        $condition = ['and',
            ['=', 'customer_id',   (int) Tools::getUser()->getId()],
            ['=', 'new', 1],
            ['not', ['order_message_relation.message_id' => null]]
        ];

        return (int) $this->removeCollectionLimit()
            ->andWhere($condition)
            ->countCollection();
    }

}
