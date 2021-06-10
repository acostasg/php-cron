<?php


namespace CronBundle\Application\Command;

use CronBundle\Domain\Models\Collection\JobCollection;

class ScheduleJobsUseCase
{
    /**
     *  Execute jobs, return false if no exist job for execute
     * @param JobCollection $jobCollection
     * @return bool
     */
    public function execute(JobCollection $jobCollection): bool
    {
        if ($jobCollection->isEmpty()) {
            return false;
        }

        return true;
    }
}
