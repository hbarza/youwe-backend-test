<?php
/**
 * Copyright © Codnitive, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace app\modules\Codnitive\Calendar\models;

use app\modules\Codnitive\Calendar\models\Gregorian;

class Persian
{
    const PERSIAN_EPOCH = 1948321;

    protected $_monthNames = [
        'full' => [
            'default' => [
                1 => 'Farvardin', 'Ordibehesht', 'Khordad',
                    'Tir', 'Mordad', 'Shahrivar',
                    'Mehr', 'Aban', 'Azar',
                    'Dey', 'Bahman', 'Esfand',
            ],
        ],
        'short' => [
            'default' => [
                1 => 'Far', 'Ord', 'Kho',
                    'Tir', 'Mor', 'Sha',
                    'Meh', 'Aba', 'Aza',
                    'Dey', 'Bah', 'Esf',
            ],
        ],
    ];

    public function getMonthName(int $monthNumber, string $nameType = 'full'): string
    {
        return $this->_monthNames[$nameType]['default'][$monthNumber];
    }

    public function getDate(string $gregorianDate, string $format = 'Y-m-d')
    {
        $date   = new \DateTime($gregorianDate);
        $year   = (int) $date->format('Y');
        $month  = (int) $date->format('n');
        $day    = (int) $date->format('j');
        $jdn    = (new Gregorian)->dateToJdn($year, $month, $day);
        $parts  = $this->jdnToDate($jdn);
        $mMonth = sprintf('%02d', $parts['month']);
        $dDay   = sprintf('%02d', $parts['day']);
        return $format 
            ? "{$parts['year']}-{$mMonth}-{$dDay}"
            : $parts;
    }

    public function jdnToDate(float $jdn): array
    {
        $ycycle;
        $aux1;
        $aux2;
        $yday;
        $depoch = $jdn - $this->dateToJdn(475, 1, 1);
        $cycle = (int) $this->fix($depoch / 1029983);
        $cyear = $depoch % 1029983;

        if ($cyear == 1029982) {
            $ycycle = 2820;
        }
        else {
            $aux1 = (int) $this->fix($cyear / 366);
            $aux2 = $cyear % 366;
            $ycycle = (int) floor(((2134 * $aux1) + (2816 * $aux2) + 2815) / 1028522) + $aux1 + 1;
        }

        $year = $ycycle + (2820 * $cycle) + 474;
        if ($year <= 0)
            $year--;

        $yday = ($jdn - $this->dateToJdn($year, 1, 1)) + 1;
        $month = ($yday <= 186) ? $this->ceil($yday / 31) : $this->ceil(($yday - 6) / 30);
        $day = ($jdn - $this->dateToJdn($year, $month, 1)) + 1;

        return array('year' => (int) $year, 'month' => (int) $month, 'day' => (int) $day);
    }

    public function dateToJdn(int $year, int $month, int $day): float
    {
        $epbase;
        $epyear;
        $mdays;

        $epbase = $year - (($year >= 0) ? 474 : 473);
        $epyear = 474 + ($epbase % 2820);

        $mdays = ($month <= 7) ? (((int) ($month) - 1) * 31) : (((int) ($month) - 1) * 30 + 6);

        $jdn = (int) ($day)
                + $mdays
                + (int) $this->fix((($epyear * 682) - 110) / 2816)
                + ($epyear - 1) * 365
                + (int) $this->fix($epbase / 2820) * 1029983
                + (self::PERSIAN_EPOCH - 1);

        return (float) $jdn;
    }

    public function isLeapYear(int $year): bool
    {
        return (((((($year - (($year > 0) ? 474 : 473)) % 2820) + 474) + 38) * 682) % 2816) < 682;
    }

    public function fix(float $number): int
    {
        $parts = explode('.', (string) $number);
        return (int) $parts[0];
    }
    
    public function ceil(float $number): int
    {
        return -$this->sign($number) * floor(-abs($number));
    }
    
    public function sign(float $number)
    {
        return ($number == 0) ? 0 : ($number > 0) ? 1 : -1;
    }

}
