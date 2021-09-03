# Simple logger for php

## Install
Install via composer:
```sh
composer require marck-devs/simple-logger
```

## Usage

### LogLevels
This class contains all levels available for the logger:
- DEBUG
- LOG
- INFO
- WARN
- ERROR
- CRITICAL

Also have static method to parse string and get the corresponding level:
```php
    LogLevels::log_level_from_string("debug");
```
With this method you can read the log level from .env or config file and load into logger.


### SimpleLogger
This is the main class.

 #### Method: **public function __construct($name, $level, $date_format, $log_format)**
 - **$name** is the name of the logger, defaults is *app*
 - **$level** is the min log level that will show, default is `LogLevels::WARN`
 - **$date_format** is an _DateFormatter_ interface implementation, defaults is *SimpleDateFormatter*
 - **$log_format** is an _LogForammtter_ interface implementation, defaults is _SimpleFormatter_

--- 
#### **public function log($msg, $data=[])**
#### **public function info($msg, $data=[])**
#### **public function debug($msg, $data=[])**
#### **public function warn($msg, $data=[])**
#### **public function error($msg, $data=[])**
#### **public function critical($msg, $data=[])**

Write a line in the default output stream whit the passed message. This message can be formatted as
python format function. In the message can put any key into braces and generate the array as dictionary whit the key and the 
value:
```php
    class Foo{
        private static $log;

        public function __construct(){
            self::$log = new \MarckDevs\SimpleLogger\SimpleLogger("name", \MarckDevs\SimpleLogger\LogLeves::WARN);
        }

        public function fun(){
            self::$log->log("My message is {message}", ["message" => "hello"]);
            self::$log->warn("My message is {test}", ["test" => "test"]);
            self::$log->debug("My {cnt} is {message}", ["message" => "hello", "ctn"=>"message"]);
            self::$log->error("My message is {message}", ["message" => "hello"]);
        }
    }
```
There are same reserved keywords:
- {file} - get the file path
- {date} - the time date
- {user} - the current user
- {class} - the class that call logger
- {function} - the function that call logger
- {line} - the line from has been called
- {lv} - the log level

If want a personal format for logger, you can create a class that implements **LogFormatter**.

## Save into log files
The _SimpleLogger_ has two method to set the logs file and the errors file:
```php
    SimpleLogger::set_log_file($path_to_file);
    SimpleLogger::set_error_file($path_to_file);
```
With this the default output stream will change to the files.
