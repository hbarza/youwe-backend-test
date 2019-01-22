<?php

namespace app\modules\Codnitive\Message\models\Account;

use yii\widgets\ListView;
use app\modules\Codnitive\Core\helpers\Tools;
// use app\modules\Codnitive\Message\models\Account\Grid as MessagesGrid;
use app\modules\Codnitive\Core\models\Grid\GridAbstract;

class MessagesList extends GridAbstract
{
    protected $_modelClass      = '\app\modules\Codnitive\Message\models\Message\Relation';
    protected $_sortAttributes  = [];
    protected $_actionsTemplate = '';

    protected function _prepareDataCollection($columns = [])
    {
        $columns = [
            'message.id',
            'message.created_at',
            'user.fullname',
            'order_message_relation.id AS relation_id',
            'order_message_relation.customer_id',
            'order_message_relation.new',
            "GROUP_CONCAT(message.message ORDER BY message.id SEPARATOR '|') as 'message'"
        ];

        $collection = parent::_prepareDataCollection($columns);
        return $collection->leftJoin(
                'message', 
                "order_message_relation.message_id REGEXP CONCAT('[,]{0,1}', message.id, '[,]{0,1}')"
            )->leftJoin(
                'user', 
                'message.merchant_id = user.id'
            )
            ->where(['order_message_relation.customer_id' => Tools::getUser()->id])
            ->andWhere(['not', ['order_message_relation.message_id' => null]])
            ->andWhere(['order_message_relation.new' => 1])
            ->groupBy(['message.id']);
    }

    public function toHtml()
    {
        return ListView::widget([
            'dataProvider'  => $this->getDataProvider(),
            'summary'       => '',
            'layout'        => "{items}",
            // 'itemView'      => '@app/modules/Codnitive/Message/views/account/top/new_message_template.php'
            'itemView'      => function ($model, $key, $index, $widget) {
                return $this->_getItemHtml($model, $key);
            }
        ]);
    }

    private function _getItemHtml($model, $key)
    {
        $time = Tools::getFormatedTime($model->created_at);
        $url  = $this->_getRowUrl($model, $key);
        $html = <<<HTML
        <a class="dropdown-item" href="{$url}">
            <strong>{$model->fullname}</strong>
            <span class="small float-right text-muted">{$time}</span>
            <div class="dropdown-message small">{$model->message}</div>
        </a>
        <div class="dropdown-divider"></div>
HTML;
        return $html;

    }

    protected function _getRowUrl($model, $key)
    {
        return Tools::getUrl(
            'account/message/view',
            [
                'id'      => $key,
                'data_id' => $model->relation_id
            ]
        );
    }

    protected function _prepareColumnsFormat()
    {
        return [];
    }

    protected function _getActionButtons()
    {
        return [];
    }

    protected function _getActionUrls($action, $model, $key, $index)
    {
        return '';
    }
}
