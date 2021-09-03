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
- {lvl} - the log level
- {msg} - the log message

If want a personal format for logger, you can create a class that implements **LogFormatter**.

## Save into log files
The _SimpleLogger_ has two method to set the logs file and the errors file:
```php
    SimpleLogger::set_log_file($path_to_file);
    SimpleLogger::set_error_file($path_to_file);
```
With this the default output stream will change to the files.

## Make custom formatter
The log formatter set the way to print the log line into the main output stream. To create custom, you will need to implement the `LogFormatter` interface.
```php
    class MyFormatter implements \MarckDevs\SimpleLogger\Interfaces\LogFormatter{
        public function format($string, $data = []){
            $my_format = "{date}- {lv}- {msg}";
            // generate the array with the necessaries keys
            $arr = \MarkDevs\SimpleLogger\SimpleFormatter::gen_arr($string, $data);
            // format the string
            return \MarkDevs\SimpleLogger\SimpleFormatter::set_data($string, $arr);
        }
    }
```

When you have your custon formatter you can set to the logger via static method or constructor:
```php
\MarckDevs\SimpleLogger\SimpleLogger::set_log_format(new MyFormatter());
```
**In both case the formatter is set globally.**

## Formating the date
The default format for date is the Spanish format: `d-m-Y H:i:s`, but this can be 
change to custom format creatin an implementation from `DateFormatter` interface.

```php
    class MyDateFormatter implements\MarckDevs\SimpleLogger\Interfaces\DateFormatter{

        public function get_date($date /*DateTime object*/): String {
            // custom format
            $format = "Y-m-d H:i:s"; // php format
            return $date->format($format);
        }
    }
```
To set to the logger, like before, you can set in the constructor or with the static method:
```php
    \MarckDevs\SimpleLogger\SimpleLogger::set_date_format(new MyDateFormatter());
```
## Set Log level
To set the log level for the logger we have the static method `set_log_level(int)`
It need a **LogLevel** constant.
```php
\MarckDevs\SimpleLoggerSimpleLogger::set_log_level(\MarckDevs\SimpleLogger\LogLevels::INFO)
```
## File paths
When visualize the file path whit the `{file}` option, dont show full path, only the 
file name and same parent dir. The number of parent can be change by setting in the 
static method `set_dir_level(int)`. If is set 2 levels, only will show 2 dir parents.