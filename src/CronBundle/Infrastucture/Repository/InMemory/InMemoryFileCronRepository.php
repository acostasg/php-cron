<?php


namespace CronBundle\Infrastucture\Repository\InMemory;

use CronBundle\Domain\Models\Collection\JobCollection;
use CronBundle\Domain\Models\Factory\JobFactory;
use CronBundle\Domain\Repository\CronJobsRepository;

class InMemoryFileCronRepository implements CronJobsRepository
{
    private JobCollection $jobCollection;

    /**
     * InMemoryFileCronRepository constructor.
     */
    public function __construct()
    {
        $this->jobCollection = new JobCollection();
        $this->jobCollection->add(
            JobFactory::build(
                'CommandTest',
                ['test'],
                '8 * * * *'
            )
        );
        $this->jobCollection->add(
            JobFactory::build(
                'CommandTest2',
                ['test2'],
                '5 * * * *'
            )
        );
    }

    /**
     * @return JobCollection
     */
    public function getJobs(): JobCollection
    {
        return $this->jobCollection;
    }
}
