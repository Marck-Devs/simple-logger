<?php
namespace MarckDevs\SimpleLogger\Utils;

class StringUtils{
  
  public static function formatBySize($text, $length){
    $txtLenght = strlen($text);
    $out = array();
    $out["max"] = $length;
    if($txtLenght % 2 != 0){
      $txtLenght += 1;
      $text = $text + " ";
    }
    $diff = $length - $txtLenght;
    if($diff <= 0){
      $out["max"] = $txtLenght + 2;
      $diff = 2;
    }
    if($diff % 2 != 0){
      $diff += 1;
    }
    $side = floor($diff / 2);
    $span = "";
    for($i = 0; $i < $side; $i++){
      $span += " ";
    }
    $out["text"] =  $span . $text . $span;
    return $out;
  }

  public static function format($line, $data){
    $out = $line;
    foreach ($data as $key => $value) {
        $out = str_replace("{".$key."}", $value, $out);
    }
    return $out;
}
}