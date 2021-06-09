<?php


namespace CronBundle\Application\Cli;

class Cron implements ConsoleInterface
{
    public function run(): void
    {
        echo 'OK';
    }
}
