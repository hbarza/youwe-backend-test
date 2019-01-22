<?php

namespace app\modules\Codnitive\Message\actions\Account;

use Yii;
use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Account\models\User;
use app\modules\Codnitive\Message\models\Message;
use app\modules\Codnitive\Message\models\Message\Relation;
use app\modules\Codnitive\Catalog\models\EntityFactory;

class ViewAction extends Action
{
    public function run()
    {
        $this->controller->layout = '@app/modules/Codnitive/Account/views/layouts/main';
        $this->controller->view->params['breadcrumbs'][1] = [
            'label' => 'Messages',
            'url'   => [Tools::getUrl('account/message/list', [], false)],
        ];

        $message  = (new Message)->loadOne(Yii::$app->request->get('id'));
        $merchant = (new User)->loadOne($message->merchant_id);
        $relation = (new Relation)->loadOne(Yii::$app->request->get('data_id'));
        $entity   = new EntityFactory($relation->entity_type, $relation->entity_id);
        return $this->controller->render(
            '/account/message/view', 
            [
                'message'     => $message,
                'merchant'    => $merchant,
                'entity'      => $entity->load(),
                'orderNumber' => (new Order)->getOrderNumber(true, $relation->order_id)
            ]
        );
    }
}
