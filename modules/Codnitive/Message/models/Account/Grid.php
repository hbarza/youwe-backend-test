<?php

namespace app\modules\Codnitive\Message\models\Account;

use Yii;
use yii\helpers\Html;
use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Core\models\Grid\GridAbstract;

class Grid extends GridAbstract
{
    protected $_modelClass      = '\app\modules\Codnitive\Message\models\Message\Relation';
    protected $_sortAttributes  = ['id', 'order_number', 'message', 'created_at', 'new'];
    protected $_actionsTemplate = '{view}';

    protected function _prepareDataCollection($columns = [])
    {
        /**
         * Based on accepted answer here
         * https://stackoverflow.com/questions/21134904/how-to-join-two-columns-with-one-serialized-data
         * 
         * $query = <<<QRY
         *     SELECT  msg.id,
         *             GROUP_CONCAT(msg.message ORDER BY msg.id SEPARATOR '|') as 'message',
         *             r.order_id
         *     FROM order_message_relation AS r
         *     LEFT JOIN message AS msg
         *         ON r.message_id REGEXP CONCAT('[,]{0,1}', msg.id, '[,]{0,1}')
         *     WHERE customer_id = :customer_id 
         *         AND message_id IS NOT NULL
         *     GROUP BY msg.id;
         * QRY;
         */
        $columns = [
            'message.id',
            'message.created_at',
            'order_message_relation.id AS relation_id',
            'order_message_relation.order_id',
            'order_message_relation.new',
            "GROUP_CONCAT(message.message ORDER BY message.id SEPARATOR '|') as 'message'"
        ];
        $collection = parent::_prepareDataCollection($columns);
        return $collection->leftJoin(
                'message', 
                "order_message_relation.message_id REGEXP CONCAT('[,]{0,1}', message.id, '[,]{0,1}')"
            )
            ->where(['order_message_relation.customer_id' => Tools::getUser()->id])
            ->andWhere(['not', ['order_message_relation.message_id' => null]])
            ->groupBy(['message.id']);
    }

    protected function _prepareColumnsFormat()
    {
        return [
            'id',
            [
                'attribute' => 'order_number',
                'format' => 'html',
            ],
            [
                'attribute' => 'message',
                'format' => 'html',
                'contentOptions' => [
                    'class' => 'text-truncate',
                    'style' => 'max-width: 300px;'
                ],
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Date',
                'contentOptions' => ['class' => 'text-nowrap'],
                'format'     => ['date', 'YYYY-MM-dd']
            ],
            [
                'attribute' => 'new',
                'format' => 'html',
                'label' => 'Status',
                'contentOptions' => ['class' => 'message text-center'],
                'value' => function ($model) {
                    return $model->new ? '<div class="bg-success text-white">New</div>' : '';
                },
            ]
        ];
    }

    protected function _getActionButtons()
    {
        return [
            'view' => function ($url, $model) {
                return Html::a('<span class="btn btn-info">Message Details</span>', $url, [
                    'title' => __('app', 'View Message Details'),
                ]);
            }
        ];
    }

    protected function _getActionUrls($action, $model, $key, $index)
    {
        return Tools::getUrl(
            'account/message/view',
            [
                'id'      => $key,
                'data_id' => $model->relation_id
            ]
        );
    }
}
