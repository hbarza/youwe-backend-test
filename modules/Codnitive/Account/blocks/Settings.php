<?php 

namespace app\modules\Codnitive\Account\blocks;

class Settings extends \app\modules\Codnitive\Core\blocks\Template
{
    public function getProfileAction()
    {
        return app()->getRequest()->get('action', 'profile');
    }
}
