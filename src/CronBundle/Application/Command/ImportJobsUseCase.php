<?php


namespace CronBundle\Application\Command;

use CronBundle\Domain\Models\Collection\JobCollection;
use CronBundle\Domain\Repository\CronJobsRepository;
use CronBundle\Domain\Repository\Exception\JobsNotFoundException;

class ImportJobsUseCase
{
    private CronJobsRepository $cronJobsRepository;

    /**
     * ImportJobsUseCase constructor.
     * @param CronJobsRepository $cronJobsRepository
     */
    public function __construct(CronJobsRepository $cronJobsRepository)
    {
        $this->cronJobsRepository = $cronJobsRepository;
    }


    /**
     * @return JobCollection
     */
    public function execute(): JobCollection
    {
        try {
            return $this->cronJobsRepository->getJobs();
        } catch (JobsNotFoundException $e) {
            return new JobCollection();
        }
    }
}
