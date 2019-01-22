<?php 
namespace app\modules\Codnitive\Bus\blocks;

use yii\helpers\Json;

class City extends \app\modules\Codnitive\Core\blocks\Template
{
    public function getSelectOptions(array $options, string $selector = ''): string
    {
        $html = $selector ? '<option value="">'.$selector.'</option>' : '';
        foreach ($options as $value => $label) {
            $html .= '<option value="'.$value.'">'.$label.'</option>';
        }
        return $html;
    }
}
