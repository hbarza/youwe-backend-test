<?php

namespace app\modules\Codnitive\Cms\actions\Terms;

use app\modules\Codnitive\Core\actions\Action;

class IndexAction extends Action
{
    public function run()
    {
        return $this->controller->render('/templates/terms/index.phtml');
    }
}
