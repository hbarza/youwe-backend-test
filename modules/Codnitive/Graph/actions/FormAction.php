<?php

namespace app\modules\Codnitive\Graph\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Graph\models\Form;

class FormAction extends Action
{
    /**
     * cleans session and renders ordered cards deck
     */
    public function run()
    {
        return $this->controller->render('/templates/form.phtml', ['model' => new Form]);
    }
}
