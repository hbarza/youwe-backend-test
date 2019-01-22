<?php

namespace app\modules\Codnitive\Message\actions\Account;


use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Message\models\Account\Grid;

class ListAction extends Action
{
    public function run()
    {
        $this->controller->layout = '@app/modules/Codnitive/Account/views/layouts/main';
        return $this->controller->render('/account/list', ['messageGrid' => new Grid]);
    }
}
