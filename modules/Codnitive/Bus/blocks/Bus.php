<?php 
namespace app\modules\Codnitive\Bus\blocks;

use yii\helpers\Json;

class Bus extends \app\modules\Codnitive\Bus\blocks\SearchForm
{
    const SEATS_COLUMN_COUNT = 5;

    public function getSeatMap($bus): array
    {
        $rowsCount = $this->getRowsCount($bus);
        $map = [];
        $seatMap = $bus['seat_map'];
        for ($column = self::SEATS_COLUMN_COUNT; $column >= 1; $column--) {
            $map[$column] = '';
            if (isset($seatMap[$column])) {
                for ($row = 1; $row <= $rowsCount; $row++) {
                    if (isset($seatMap[$column][$row])) {
                        $seatNumber    = $seatMap[$column][$row]['seat_number'];
                        $map[$column] .= $seatMap[$column][$row]['status']. "[$seatNumber,$seatNumber]";
                    }
                    else {
                        $map[$column] .= '_';
                    }
                }
            }
            else {
                $map[$column] = str_repeat('_', $rowsCount);
            }
        }
        return $map;
    }

    public function getRowsCount($bus): int
    {
        $rows = 0;
        for ($column = 1; $column <= self::SEATS_COLUMN_COUNT; $column++) {
            if (isset ($bus['seat_map'][$column])) {
                $rows = max($rows, count($bus['seat_map'][$column]));
            }
        }
        return $rows;
    }

    public function getUnavailableSeats($bus): string
    {
        $seatNumbers = [];
        for ($column = self::SEATS_COLUMN_COUNT; $column >= 1; $column--) {
            if (isset($bus['seat_map'][$column])) {
                foreach ($bus['seat_map'][$column] as $row) {
                    if ($row['status'] != 'a') {
                        $seatNumbers[] = $row['seat_number'];
                    }
                }
            }
        }
        return Json::encode($seatNumbers);
    }

    public function getActionUrl (): string
    {
        return tools()::getUrl('bus/process/saveSeats');
    }
}
