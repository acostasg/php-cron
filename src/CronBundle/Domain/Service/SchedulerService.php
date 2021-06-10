<?php


namespace CronBundle\Domain\Service;

use CronBundle\Domain\Models\Job;

class SchedulerService
{
    public function processJob(Job $job): Job
    {
        return $job;
    }
}
