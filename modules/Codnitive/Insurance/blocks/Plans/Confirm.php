<?php 

namespace app\modules\Codnitive\Insurance\blocks\Plans;

use app\modules\Codnitive\Core\blocks\Template;
use app\modules\Codnitive\Insurance\models\Insurance;

class Confirm extends Template
{
    public function getInsuranceData()
    {
        return app()->session->get('__virtual_cart')['insurance'];
    }

    public function getGrandTotal(array $allInsurances, bool $number = false): string
    {
        $grandTotal = (new Insurance)->getGrandTotal($allInsurances);
        return $number ? $grandTotal : tools()->formatRial($grandTotal);
    }
}
