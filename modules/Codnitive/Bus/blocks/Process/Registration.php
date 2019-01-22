<?php 

namespace app\modules\Codnitive\Bus\blocks\Process;

use app\modules\Codnitive\Core\blocks\Template;

class Registration extends Template
{
    public function getBackUrl()
    {
        $searchParams = app()->session->get('__virtual_cart')['bus'];
        $params = [
            'path' => "{$searchParams['origin_name']}-{$searchParams['destination_name']}",
            'departing' => str_replace('/', '-', $searchParams['departing_persian']),
        ];
        return tools()->getUrl('bus/process/result', $params);
    }
}
