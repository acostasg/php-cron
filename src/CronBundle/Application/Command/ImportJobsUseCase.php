<?php


namespace CronBundle\Application\Command;

use CronBundle\Domain\Models\Collection\JobCollection;
use CronBundle\Domain\Repository\CronJobsRepository;

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
        return $this->cronJobsRepository->getJobs();
    }
}
