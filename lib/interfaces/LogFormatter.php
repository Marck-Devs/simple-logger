<?php
namespace MarckDevs\SimpleLogger\Interfaces;

interface LogFormatter{
    public function format($string, $data = false) : String;
}