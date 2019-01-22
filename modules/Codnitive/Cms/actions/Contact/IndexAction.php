<?php

namespace app\modules\Codnitive\Cms\actions\Contact;

use app\modules\Codnitive\Core\actions\Action;

class IndexAction extends Action
{
    public function run()
    {
        return $this->controller->render('/templates/contact/index.phtml');
    }
}
