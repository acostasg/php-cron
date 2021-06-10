<?php


namespace CronBundle\Infrastucture\Repository;

use CronBundle\Domain\Models\Collection\JobCollection;
use CronBundle\Domain\Repository\CronJobsRepository;

class FileCronRepository implements CronJobsRepository
{
    /**
     * @return JobCollection
     */
    public function getJobs(): JobCollection
    {
        return new JobCollection();
    }
}
