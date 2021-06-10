<?php


namespace CronBundle\Application\Service\Logger;

use Psr\Log\LoggerInterface;

class LoggerConsole implements LoggerInterface
{
    public function emergency($message, array $context = array())
    {
        echo  "EMERGENCY: ".$message . PHP_EOL;
    }

    public function alert($message, array $context = array())
    {
        echo  "ALERT: ".$message. PHP_EOL;
    }

    public function critical($message, array $context = array())
    {
        echo  "CRITICAL: ".$message. PHP_EOL;
    }

    public function error($message, array $context = array())
    {
        echo  "ERROR: ".$message. PHP_EOL;
    }

    public function warning($message, array $context = array())
    {
        echo  "WARNING: ".$message. PHP_EOL;
    }

    public function notice($message, array $context = array())
    {
        echo  "NOTICE: ".$message. PHP_EOL;
    }

    public function info($message, array $context = array())
    {
        echo  "INFO: ".$message. PHP_EOL;
    }

    public function debug($message, array $context = array())
    {
        echo  "DEDUG: ".$message. PHP_EOL;
    }

    public function log($level, $message, array $context = array())
    {
        echo  "8LOG:: ".$message. PHP_EOL;
    }
}
