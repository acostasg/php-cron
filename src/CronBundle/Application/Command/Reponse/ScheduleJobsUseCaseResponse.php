<?php


namespace CronBundle\Application\Command\Reponse;

use CronBundle\Domain\Models\Collection\JobCollection;
use CronBundle\Domain\Models\Job;

class ScheduleJobsUseCaseResponse
{
    private JobCollection $errorJobsExecution;

    private JobCollection  $jobsProcessedSuccessful;

    public function __construct()
    {
        $this->errorJobsExecution = new JobCollection();
        $this->jobsProcessedSuccessful = new JobCollection();
    }


    public function addJobError(Job $job): void
    {
        $this->errorJobsExecution->add($job);
    }

    public function getJobErrors(): JobCollection
    {
        return $this->errorJobsExecution;
    }

    public function addJobSuccessful(Job $job): void
    {
        $this->jobsProcessedSuccessful->add($job);
    }

    public function getsuccessfulJobs(): JobCollection
    {
        return $this->jobsProcessedSuccessful;
    }
}
