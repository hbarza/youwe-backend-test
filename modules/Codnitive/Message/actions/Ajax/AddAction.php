<?php

namespace app\modules\Codnitive\Message\actions\Ajax;

use Yii;
use yii\base\Action;
use yii\helpers\Json;
use app\modules\Codnitive\Message\models\Message;

class AddAction extends Action
{
    public function run()
    {
        $params = Yii::$app->request->post('Message');
        try {
            if ((new Message)->setData($params)->save()) {
                $content = '<div class="alert alert-success">Your message has been sent succesfully!</div>';
            }
            else {
                throw new \Exception('Your message has not been sent!');
            }
        }
        catch (\Exception $e) {
            $content = '<div class="alert alert-danger">'.$e->getMessage().'</div>';
        }
        $response = [
            [
                'element' => '#message_modal .modal-flash-message',
                'type'    => 'html',
                'content' => $content
            ]
        ];
        return Json::encode($response);
    }
}
