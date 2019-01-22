<?php 
namespace app\modules\Codnitive\Bus\blocks;

class Filter extends \app\modules\Codnitive\Bus\blocks\SearchForm
{
    const PRICE_STEPS = 100000;
    const DEPARTING_STEPS = 1;
    protected $foundBuses;

    public function __construct(array $foundBuses)
    {
        $this->foundBuses = $foundBuses;
    }
    
    public function getArrayColumn(string $column): array
    {
        return array_unique(array_column($this->foundBuses, $column));
    }

    public function getFilterOptions(string $keyColumn, string $valueColumn): array
    {
        $options = [];
        foreach ($this->foundBuses as $bus) {
            $options[$bus[$keyColumn]] = $bus[$valueColumn];
        }
        return array_unique($options);
    }

    public function getCompanies(): array
    {
        // $companies = $this->getArrayColumn('company');
        $companies = $this->getFilterOptions('company_id', 'company');
        return count($companies) > 1 ? $companies : [];
    }

    public function getBoardingsList(): array
    {
        // $companies = $this->getArrayColumn('boarding');
        $companies = $this->getFilterOptions('boarding_english', 'boarding');
        return count($companies) > 1 ? $companies : [];
    }

    public function getDroppingsList(): array
    {
        // $companies = $this->getArrayColumn('dropping');
        $companies = $this->getFilterOptions('dropping_english', 'dropping');
        return count($companies) > 1 ? $companies : [];
    }

    public function getPriceRange($buses): array
    {
        $prices = $this->getArrayColumn('final_price');

        $minPrice = min($prices);
        $maxPrice = max($prices);
        $minPrice = round($minPrice - self::PRICE_STEPS, -strlen((string) $minPrice) + 1);
        $maxPrice = round($maxPrice + self::PRICE_STEPS, -strlen((string) $maxPrice) + 1);

        return [
            'min' => $minPrice,
            'max' => $maxPrice,
            'step' => self::PRICE_STEPS
        ];
    }

    public function getDepartingRange($buses): array
    {
        $departings = $this->getArrayColumn('departing');
        foreach ($departings as $key => $departing) {
            $departings[$key] = intval($departing);
            // $departings[$key] = str_replace(':', '', $departing);
        }
        return [
            'min' => min($departings),
            'max' => max($departings),
            'step' => self::DEPARTING_STEPS
        ];
    }
}
