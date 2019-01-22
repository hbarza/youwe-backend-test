<?php

namespace app\modules\Codnitive\SepMicro\models\System\Source;

use app\modules\Codnitive\Core\models\System\Source\OptionsArray;

class VerificationError extends OptionsArray
{
    public function optionsArray()
    {
        return [
            -1 => __('sepmicro', 'Error in sent info process'),
            -3 => __('sepmicro', 'Invalid characters in arguments'),
            -4 => __('sepmicro', 'Merchant authentication failed'),
            -6 => __('sepmicro', 'Transaction was reverted or session expired'),
            -7 => __('sepmicro', 'Empty reference number'),
            -8 => __('sepmicro', 'Arguments length are longer than valid length'),
            -9 => __('sepmicro', 'Invalid characters in revert amount'),
            -10 => __('sepmicro', 'Reference number is not a valid Base64'),
            -11 => __('sepmicro', 'Arguments length are shorter than valid length'),
            -12 => __('sepmicro', 'Revert amount is negative'),
            -13 => __('sepmicro', 'Revert amount for sub revert is more than available amount'),
            -14 => __('sepmicro', 'Invalid transaction'),
            -15 => __('sepmicro', 'Revert amount is float number'),
            -16 => __('sepmicro', 'Gateway internal server error'),
            -17 => __('sepmicro', 'Sub revert is not valid'),
            -18 => __('sepmicro', 'Invalid merchant IP address or invalid reverseTransaction password'),
        ];
    }
}
