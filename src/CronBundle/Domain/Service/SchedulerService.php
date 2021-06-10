<?php


namespace CronBundle\Domain\Service;

use CronBundle\Domain\Models\Job;

class SchedulerService
{
    private ExecuteCommand $executeCommand;

    /**
     * SchedulerService constructor.
     * @param ExecuteCommand $executeCommand
     */
    public function __construct(ExecuteCommand $executeCommand)
    {
        $this->executeCommand = $executeCommand;
    }

    /**
     * @param Job $job
     * @return Job
     */
    public function processJob(Job $job): Job
    {
        if ($job->getExpression()->isDue()) {
            return $this->executeCommand->exec($job);
        }
        return $job;
    }
}
