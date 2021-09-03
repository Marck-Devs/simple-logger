<?php

namespace MarckDevs\SimpleLogger;

use DateTime;
use MarckDevs\SimpleLogger\Interfaces\DateFormatter;
use MarckDevs\SimpleLogger\Interfaces\LogFormatter;
use MarckDevs\SimpleLogger\LogLevels;

/**
 * Logger class
 * @version 1.0.0
 * @author Marck Devs
 * @see https://github.com/marck-dev/simple-logger
 */
class SimpleLogger
{
    private static $date_format;
    private static $log_format;
    private static $log_level;
    private static $dir_level = 2;
    private static $error_file = false;
    private static $log_file = false;
    private static $is_file_log = false;
    private $name;

    public static function get_dir_level()
    {
        return self::$dir_level;
    }

    /**
     * Set the num of dir to see in the  log line when {file} key is set
     * @param int $dir_level the num of directories
     */
    public static function set_dir_level($dir_level)
    {
        self::$dir_level = $dir_level+1;
    }

    public static function set_log_file($log_file)
    {
        self::$log_file = $log_file;
    }

    public static function set_error_file($error_file)
    {
        self::$error_file = $error_file;
    }

    public static function set_date_format($date_format)
    {
        self::$date_format = $date_format;
    }

    public static function set_log_format($log_format)
    {
        self::$log_format = $log_format;
    }
    public static function set_log_level($log_level)
    {
        self::$log_level = $log_level;
    }
    /**
     * Constructor
     * @param string $name the logger name
     * @param int $log_level the log level
     * @param DateFormatter $date_format the date formatter to use
     * @param LogFormatter $log_format the log format to use
     *
     */
    public function __construct($name = "app", $log_level = LogLevels::WARN, $date_format = false, $log_format = false)
    {
        $this->name = $name;
        if (!isset(self::$date_format) && $date_format != false) {
            self::$date_format = $date_format;
        } else {
            if(!isset(self::$date_format))
                self::$date_format = new SimpleDateFormatter();
        }
        if (!isset(self::$log_format) && $log_format != false) {
            self::$log_format= $log_format;
        } else {
            if(!isset(self::$log_format))
                self::$log_format = new SimpleFormatter();
        }
        if(!isset(self::$log_level))
            self::$log_level = $log_level;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }

    private  static function check_if_file()
    {
        self::$is_file_log = self::$error_file != false || self::$log_file != false;
        return self::$is_file_log;
    }

    private function gen_data($in_data, $lvl)
    {
        $tmp = [
            "lvl" => $lvl,
            "name" => $this->name,
            "date" =>  self::$date_format->get_date(new DateTime("now"))
        ];
        return array_merge($tmp, $in_data);
    }

    /**
     * Add a break line char if not have yet
     * @param string $line th strin to process
     * @return string the string with break line at the end
     */
    public static function add_br($line)
    {
        if (!CommonsUtils::ends_with($line, "\n")) {
            return $line . "\n";
        } else {
            return $line;
        }
    }

    private function save_log($line)
    {
        $file = fopen(self::$log_file, "a");
        fwrite($file, $line);
        fclose($file);
    }

    private function save_error($line)
    {
        $file = fopen(self::$error_file, "a");
        fwrite($file, $line);
        fclose($file);
    }

    /**
     * Make a log message. It can be formatter with {key} sintax.
     * In the $data param can pass the array whit the keys and values
     * @example string  log("hi {second}", ["second" => "world"]) -> "Hi world"
     * @param string $msg  the message
     * @param array $data the dictionary to format the string
     * @return void
     */
    public function log($msg, $data = []): void
    {
        if (!LogLevels::is_log_level(LogLevels::LOG, self::$log_level))
            return;
        $line =  self::$log_format->format($msg, $this->gen_data($data, "LOG"));
        $line = self::add_br($line);
        if (self::check_if_file()) {
            if (self::$log_file != false) {
                $this->save_log($line);
                return;
            }
        }
        echo $line;
    }

     /**
     * Make a info message. It can be formatter with {key} sintax.
     * In the $data param can pass the array whit the keys and values
     * @example string  info("hi {second}", ["second" => "world"]) -> "Hi world"
     * @param string $msg  the message
     * @param array $data the dictionary to format the string
     * @return void
     */
    public function info($msg, $data = []): void
    {
        if (!LogLevels::is_log_level(LogLevels::INFO, self::$log_level))
            return;
        $line =  self::$log_format->format($msg, $this->gen_data($data, "INFO"));
        $line = self::add_br($line);
        if (self::check_if_file()) {
            if (self::$log_file != false) {
                $this->save_log($line);
                return;
            }
        }
        echo $line;
    }

    /**
     * Make a debug message. It can be formatter with {key} sintax.
     * In the $data param can pass the array whit the keys and values
     * @example string  debug("hi {second}", ["second" => "world"]) -> "Hi world"
     * @param string $msg  the message
     * @param array $data the dictionary to format the string
     * @return void
     */
    public function debug($msg, $data = []): void
    {
        if (!LogLevels::is_log_level(LogLevels::DEBUG, self::$log_level))
            return;
        $line =  self::$log_format->format($msg, $this->gen_data($data, "DEBUG"));
        $line = self::add_br($line);
        if (self::check_if_file()) {
            if (self::$log_file != false) {
                $this->save_log($line);
                return;
            }
        }
        echo $line;
    }

    /**
     * Make a warn message. It can be formatter with {key} sintax.
     * In the $data param can pass the array whit the keys and values
     * @example string  warn("hi {second}", ["second" => "world"]) -> "Hi world"
     * @param string $msg  the message
     * @param array $data the dictionary to format the string
     * @return void
     */
    public function warn($msg, $data = []): void
    {
        if (!LogLevels::is_log_level(LogLevels::WARN, self::$log_level))
            return;
        $line =  self::$log_format->format($msg, $this->gen_data($data, "WARN"));
        $line = self::add_br($line);
        if (self::check_if_file()) {
            if (self::$log_file != false) {
                $this->save_log($line);
                return;
            }
        }
        echo $line;
    }

    /**
     * Make a error message. It can be formatter with {key} sintax.
     * In the $data param can pass the array whit the keys and values
     * @example string  error("hi {second}", ["second" => "world"]) -> "Hi world"
     * @param string $msg  the message
     * @param array $data the dictionary to format the string
     * @return void
     */
    public function error($msg, $data = []): void
    {
        if (!LogLevels::is_log_level(LogLevels::ERROR, self::$log_level))
            return;
        $line =  self::$log_format->format($msg, $this->gen_data($data, "ERROR"));
        $line = self::add_br($line);
        if (self::check_if_file()) {
            if (self::$error_file != false) {
                $this->save_error($line);
                return;
            }
        }
        echo $line;
    }

    /**
     * Make a critical message. It can be formatter with {key} sintax.
     * In the $data param can pass the array whit the keys and values
     * @example string  critical("hi {second}", ["second" => "world"]) -> "Hi world"
     * @param string $msg  the message
     * @param array $data the dictionary to format the string
     * @return void
     */
    public function critical($msg, $data = []): void
    {
        if (!LogLevels::is_log_level(LogLevels::CRITICAL, self::$log_level))
            return;
        $line =  self::$log_format->format($msg, $this->gen_data($data, "CRITICAL"));
        $line = self::add_br($line);
        if (self::check_if_file()) {
            if (self::$error_file != false) {
                $this->save_error($line);
                return;
            }
        }
        echo $line;
    }
}
