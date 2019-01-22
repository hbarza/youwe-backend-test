<?php 

namespace app\modules\Codnitive\Bus\blocks\Process;

use yii\helpers\Json;
use app\modules\Codnitive\Core\blocks\Template;
use app\modules\Codnitive\Calendar\models\Persian;
use app\modules\Codnitive\Bus\models\DataProvider;

class Confirm extends Template
{
    protected $_data;
    protected $dataProvider;

    public function __construct(array $data = []) {
        $this->_data = $data;
        if (!empty($data)) {
            $this->setDataProvider($this->_data['reservation']['provider']);
        }
    }

    public function setDataProvider(string $provider): self
    {
        $this->dataProvider = new DataProvider($provider);
        return $this;
    }

    public function getDataProvider()
    {
        return $this->dataProvider;
    }

    public function getData(): array
    {
        return $this->_data;
    }

    public function getTime(string $departure): string
    {
        return (new \DateTime($departure))->format('H:i');
    }

    public function getDate(string $departure): string
    {
        return str_replace('-', '/', (new Persian)->getDate($departure));
    }

    public function getReviewSeatMap(string $seatMap, string $seatNumbers): array
    {
        $seatMap = str_replace(['m', 'f', 'a'], 'u', $seatMap);
        $seatNumbers = explode(',', $seatNumbers);
        foreach ($seatNumbers as $seatNumber) {
            $seatMap = str_replace("u[$seatNumber,$seatNumber]", "r[$seatNumber,$seatNumber]", $seatMap);
        }
        return Json::decode($seatMap);
    }

    public function getSeatsCount(): int
    {
        return $this->dataProvider->getSeatsCount($this->_data['reservation']);
    }

    public function getFinalPrice(): string
    {
        return tools()->formatRial($this->dataProvider->getFinalPrice($this->_data['data_source']));
    }

    public function getGrandTotal(bool $number = false): string
    {
        return $number
            ? $this->dataProvider->getGrandTotal($this->_data)
            : tools()->formatRial($this->dataProvider->getGrandTotal($this->_data));
    }

    public function showPnr(): bool
    {
        return $this->dataProvider->hasPnr();
    }
}
