<?php

namespace app\modules\Codnitive\Message\models;

use app\modules\Codnitive\Core\models\ActiveRecord;
use app\modules\Codnitive\Message\models\Message\Relation;
use app\modules\Codnitive\Message\models\Account\MessagesList;

class Message extends ActiveRecord
{
    public $entity_id;
    public $entity_type;

    public static function tableName()
    {
       return '{{message}}';
    }

    public function rules()
    {
       $rules = [
           [['message', 'merchant_id'], 'required']
       ];
       return $rules;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $entityId   = $this->_data['entity_id'];
        $entityType = $this->_data['entity_type'];
        $result = parent::save($runValidation, $attributeNames);
        if ($result) {
            $result = (new Relation)->addMessageToRelation(
                (int) $entityId,
                (int) $entityType,
                (int) $this->id
            );
        }
        return (int) $result;
    }

    public function getNewMessages($limit = 3)
    {
        $grid = new MessagesList;
        return $grid->setLimit($limit)->toHtml();
    }

}
