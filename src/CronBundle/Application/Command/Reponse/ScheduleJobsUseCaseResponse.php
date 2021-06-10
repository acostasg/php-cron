<?php


namespace CronBundle\Application\Command\Reponse;

use CronBundle\Domain\Models\Collection\JobCollection;
use CronBundle\Domain\Models\Job;

class ScheduleJobsUseCaseResponse
{
    private JobCollection $errorJobsExecution;

    public function __construct()
    {
        $this->errorJobsExecution = new JobCollection();
    }


    public function addJobError(Job $job): void
    {
        $this->errorJobsExecution->add($job);
    }

    public function getJobErrors(): JobCollection
    {
        return $this->errorJobsExecution;
    }
}
