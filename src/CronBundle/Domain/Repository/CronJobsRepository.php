<?php


namespace CronBundle\Domain\Repository;

use CronBundle\Domain\Models\Collection\JobCollection;
use CronBundle\Domain\Repository\Exception\JobsNotFoundException;

interface CronJobsRepository
{
    /**
     * @return JobCollection
     * @throws JobsNotFoundException
     */
    public function getJobs(): JobCollection;
}
