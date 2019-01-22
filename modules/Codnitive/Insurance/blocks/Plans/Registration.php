<?php 

namespace app\modules\Codnitive\Insurance\blocks\Plans;

use app\modules\Codnitive\Core\blocks\Template;

class Registration extends Template
{
    public function getInsuranceData()
    {
        return app()->session->get('__virtual_cart')['insurance'];
    }

    public function getBackUrl()
    {
        $searchParams = $this->getInsuranceData();
        $params = [
            'insurance' => "{$searchParams['country_name']}-{$searchParams['duration']}".__('insurance', 'days'),
            'cid' => $searchParams['country']
        ];
        return tools()->getUrl('insurance/plans', $params);
    }
}
