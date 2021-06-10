<?php


namespace CronBundle\Domain\Models\Factory;

use Cron\CronExpression;
use CronBundle\Domain\Models\Job;

class JobFactory
{
    /**
     * @param string $command
     * @param String[] $arguments
     * @param CronExpression $cronExpression
     * @return Job
     */
    public static function build(string $command, array $arguments, CronExpression $cronExpression): Job
    {
        return new Job(
            serialize($command.implode(";", $arguments)),
            $command,
            $arguments,
            new \DateTime('now'),
            $cronExpression
        );
    }
}
