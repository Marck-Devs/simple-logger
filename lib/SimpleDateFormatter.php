<?php
namespace MarckDevs\SimpleLogger;


class SimpleDateFormatter implements  \MarckDevs\SimpleLogger\Interfaces\DateFormatter{

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