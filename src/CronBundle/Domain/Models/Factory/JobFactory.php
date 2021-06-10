<?php


namespace CronBundle\Domain\Models\Factory;

use Cron\CronExpression;
use CronBundle\Domain\Models\Job;
use CronBundle\Domain\Repository\Exception\InvalidJobData;
use CronBundle\Domain\ValueObject\JobId;
use DateTime;

class JobFactory
{
    /**
     * @param string $command
     * @param string[] $arguments
     * @param CronExpression $cronExpression
     * @return Job
     * @throws InvalidJobData
     */
    public static function build(string $command, array $arguments, CronExpression $cronExpression): Job
    {
        return new Job(
            new JobId($command, $arguments),
            $command,
            $arguments,
            new DateTime('now'),
            $cronExpression
        );
    }
}
