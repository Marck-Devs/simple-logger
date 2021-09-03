<?php
namespace MarckDevs\SimpleLogger;

use MarckDevs\SimpleLogger\Interfaces\DateFormatter;

class SimpleDateFormatter implements DateFormatter{

    /**
     * @param DateTime $date The date
     * @return string the date formatted
     */
    public function get_date($date): String
    {
        $format = "d-m-Y H:i:s";
        return $date->format($format);
    }

}