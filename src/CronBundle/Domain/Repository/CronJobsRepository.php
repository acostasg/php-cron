<?php


namespace CronBundle\Domain\Repository;

use CronBundle\Domain\Models\Collection\JobCollection;

interface CronJobsRepository
{
    /**
     * @return JobCollection
     */
    public function getJobs(): JobCollection;
}
