<?php
namespace MarckDevs\SimpleLogger;

class LogLevels{
    public  const VERBOSE = 0xd00;
    public  const DEBUG = 0xd01;
    public  const INFO = 0xd02;
    public  const LOG = 0xd03;
    public  const WARN = 0xd04;
    public  const ERROR = 0xd05;
    public  const CRITICAL = 0xd06;


    /**
     * Chek if the log level can be showed in the looger.
     * @param int $log_level the level taht will be compare
     * @param int $level_set the lecel taht is set in the logger
     * @retrin bool of is les tan the log level that has been sett
     */
    public static function is_log_level($log_level, $level_set) :bool {
        return $level_set <= $log_level;
    }

    /**
     * Parse the log level string into a log level int
     * @param string $level the log level name
     * @return int the log level reference
     */
    public static function log_level_from_string($level): int{
        $lvl = strtoupper($level);
        $lvl_int = 0;
        switch ($lvl){
            case "VERBOSE":
                $lvl_int = self::VERBOSE;
                break;
            case "DEBUG":
                $lvl_int = self::DEBUG;
                break;
            case "INFO":
                $lvl_int = self::INFO;
                break;
            case "ERROR":
                $lvl_int = self::ERROR;
                break;
            case "CRITICAL":
                $lvl_int = self::CRITICAL;
                break;
            case "LOG":
                $lvl_int = self::LOG;
                break;
            default:
                $lvl_int = self::WARN;
        }
        return $lvl_int;
    }
    
}