<?php 

namespace app\modules\Codnitive\Insurance\blocks;

use app\modules\Codnitive\Core\blocks\Template;
use app\modules\Codnitive\Insurance\models\Travis;

class SearchForm extends Template
{
    protected $_travis;

    public function getTravis(): Travis
    {
        if (empty($_travis)) {
            $this->_travis = new Travis;
        }
        return $this->_travis;
    }

    public function getActionUrl()
    {
        return tools()::getUrl('insurance/plans/search');
    }

    /**
     * Generates options list of all countries for select field
     * 
     * @return  string
     */
    public function getCountriesOptions(): string
    {
        $options = '<option value="">'.__('insurance', 'Destination Country').'</option>';
        foreach ($this->getTravis()->getCountries() as $country) {
            if ($country->errorCode == -1) {
                $options .= "<option value=\"{$country->code}\">{$country->title}</option>";
            }
        }
        return $options;
    }

    public function getCountriesArray(): array
    {
        $options = [];
        foreach ($this->getTravis()->getCountries() as $country) {
            if ($country->errorCode == -1) {
                $options[$country->code] = $country->title;
            }
        }
        return $options;
    }

    /**
     * Generates options list of duration of stay for select field
     * 
     * @return  string
     */
    public function getDurationsOptions(): string
    {
        $options = '<option value="">'.__('insurance', 'Duration of Stay').'</option>';
        foreach ($this->getTravis()->getDurationsOfStay() as $duration) {
            if ($duration->errorCode == -1) {
                $options .= "<option value=\"{$duration->value}\">{$duration->title}</option>";
            }
        }
        return $options;
    }

    public function getDurationsArray(): array
    {
        $options = [];
        foreach ($this->getTravis()->getDurationsOfStay() as $duration) {
            if ($duration->errorCode == -1) {
                $options[$duration->value] = $duration->title;
            }
        }
        return $options;
    }
}
