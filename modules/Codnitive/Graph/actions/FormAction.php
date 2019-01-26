<?php

namespace app\modules\Codnitive\Graph\actions;

use app\modules\Codnitive\Core\actions\Action;

class FormAction extends Action
{
    /**
     * cleans session and renders ordered cards deck
     */
    public function run()
    {
        dump('hello');
        exit;
        return $this->controller->render(
            '/templates/game/start.phtml', 
            ['deck' => (new Deck)->getCardsDeck()]
        );
    }
}
