<?php
namespace MarckDevs\SimpleLogger\Interfaces;

interface Logger{
  public function log($text, ...$data);

  public function verbose($text, ...$data);

  public function info($text, ...$data);

  public function warn($text, ...$data);

  public function error($text, ...$data);

  public function critical($text, ...$data);
}
