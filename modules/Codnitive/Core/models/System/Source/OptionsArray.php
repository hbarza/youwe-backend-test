<?php

namespace app\modules\Codnitive\Core\models\System\Source;

abstract class OptionsArray
{
    abstract public function optionsArray();

    public function getOptionIdByValue($value)
    {
        return array_search($value, $this->optionsArray());
    }

    public function getArrayOptionIdByValue($value)
    {
        return array_intersect($this->optionsArray(), $value);
    }

    public function getOptionValue($id)
    {
        return isset(($this->optionsArray())[$id]) ? ($this->optionsArray())[$id] : false;
    }
}
