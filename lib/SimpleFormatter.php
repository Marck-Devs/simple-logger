<?php
namespace MarckDevs\SimpleLogger;

use MarckDevs\SimpleLogger\Interfaces\LogFormatter;

class SimpleFormatter implements LogFormatter{
    public function format($string, $data = []): string
    {
        $format = "{date} - {user} | {name} - [{lvl}] @ {file}:{line}  {class}->{function} :: {msg}";

        return self::set_data($format, self::gen_arr($string, $data));
    }

    public static function gen_arr($string, $data){
        return array_merge($data, ["msg"=>self::set_data($string, $data)]);
    }

    public static function set_data($text, $data){
        $debug = (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
        $default_data = $debug[count($debug)-1];
        $default_data["user"]= get_current_user();
        // formate file path
        $default_data["file"] = self::gen_file_path($default_data["file"]);
        $format = array_merge($data, $default_data);
        $regex = "/\{(?P<key>\w*)\}/m";
        preg_match_all($regex, $text, $matches, PREG_SET_ORDER, 0);
        $out = $text;
        $keys = array();
        if($matches){
            foreach ($matches as  $match) {
                if(isset($match["key"])){
                    $keys[] = $match["key"];
                }
            }
        }
        foreach ($format as $key => $value) {
            if(in_array($key, $keys)){
                $out = str_replace("{". $key ."}", $value, $out);
            }
        }
        return $out;
    }

    private static function gen_file_path($file){
        $slices = explode(DIRECTORY_SEPARATOR, $file);
        if(count($slices) > SimpleLogger::get_dir_level()){
            $slice_file = array_slice($slices, -1 * SimpleLogger::get_dir_level(), SimpleLogger::get_dir_level(), false);
        }else{
            $slice_file = $slices;
        }
        return implode(DIRECTORY_SEPARATOR, $slice_file);
    }
}