<?php

namespace app\modules\Codnitive\Message\actions\Ajax;

use Yii;
use yii\base\Action;
use yii\helpers\Json;
use app\modules\Codnitive\Message\models\Message;

class NewAction extends Action
{
    public function run()
    {
        try {
            $message = new Message;
            $content = $message->getNewMessages();
        }
        catch (\Exception $e) {
            $content = '<div class="alert alert-danger dropdown-item">'.$e->getMessage().'</div>
            <div class="dropdown-divider"></div>';
        }
        
        $response = [
            [
                'element' => '.new-messages-wrapper',
                'type'    => 'html',
                'content' => $content
            ]
        ];
        return Json::encode($response);
    }
}
