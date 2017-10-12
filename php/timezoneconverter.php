<?php
class TimeZoneConverter
{
    const DEFAULT_TIMEZONE = 'Europe/Kiev';

    private $offsetZone = [
        -39600 => 'Pacific/Pago_Pago',
        -36000 => 'Pacific/Tahiti',
        -34200 => 'Pacific/Marquesas',
        -32400 => 'Pacific/Gambier',
        -28800 => 'Pacific/Pitcairn',
        -25200 => 'America/Yellowknife',
        -21600 => 'Pacific/Galapagos',
        -18000 => 'Pacific/Easter',
        -16200 => 'America/Caracas',
        -14400 => 'Atlantic/Bermuda',
        -12600 => 'America/St_Johns',
        -10800 => 'Atlantic/Stanley',
        -7200 => 'Atlantic/South_Georgia',
        -3600 => 'Atlantic/Cape_Verde',
        0 => 'Europe/London',
        3600 => 'Europe/Zurich',
        7200 => 'Europe/Zaporozhye',
        10800 => 'Indian/Mayotte',
        12600 => 'Asia/Tehran',
        14400 => 'Indian/Reunion',
        16200 => 'Asia/Kabul',
        18000 => 'Indian/Maldives',
        19800 => 'Asia/Kolkata',
        20700 => 'Asia/Kathmandu',
        21600 => 'Indian/Chagos',
        23400 => 'Indian/Cocos',
        25200 => 'Indian/Christmas',
        28800 => 'Australia/Perth',
        31500 => 'Australia/Eucla',
        32400 => 'Pacific/Palau',
        34200 => 'Australia/Darwin',
        36000 => 'Pacific/Saipan',
        37800 => 'Australia/Broken_Hill',
        39600 => 'Pacific/Pohnpei',
        41400 => 'Pacific/Norfolk',
        43200 => 'Pacific/Wake',
        46800 => 'Pacific/Tongatapu',
        49500 => 'Pacific/Chatham',
        50400 => 'Pacific/Kiritimati',
    ];

    /**
     * @param int $offset
     * @return string time zone
     */
    public function getTimeZoneByOffset(int $offset): string
    {
        $offset = (int) $offset;
        if (isset($this->offsetZone[$offset])) {
            return $this->offsetZone[$offset];
        }

        if ($offset < -39600) {
            // return static::DEFAULT_TIMEZONE;
            throw new \InvalidArgumentException("Zone offset {$offset}");
        }

        if ($offset > 50400) {
            // return static::DEFAULT_TIMEZONE;
            throw new \InvalidArgumentException("Zone offset {$offset}");
        }

        return $this->offsetZone[(int) ceil($offset / 3600) * 3600];
    }
}
