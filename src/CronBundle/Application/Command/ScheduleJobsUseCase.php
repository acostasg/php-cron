<?php


namespace CronBundle\Application\Command;

use CronBundle\Application\Command\Reponse\ScheduleJobsUseCaseResponse;
use CronBundle\Domain\Models\Collection\JobCollection;
use CronBundle\Domain\Service\SchedulerService;

class ScheduleJobsUseCase
{
    private SchedulerService $schedulerService;

    /**
     * ScheduleJobsUseCase constructor.
     * @param SchedulerService $schedulerService
     */
    public function __construct(SchedulerService $schedulerService)
    {
        $this->schedulerService = $schedulerService;
    }


    /**
     *  Execute jobs, return false if no exist job for execute
     * @param JobCollection $jobCollection
     * @return ScheduleJobsUseCaseResponse
     */
    public function execute(JobCollection $jobCollection): ScheduleJobsUseCaseResponse
    {
        $response = new ScheduleJobsUseCaseResponse();
        foreach ($jobCollection as $job) {
            $job = $this->schedulerService->processJob($job);

            if ($job->isFailExecuted()) {
                $response->addJobError($job);
            }
            if ($job->isSuccessExecuted()) {
                $response->addJobSuccessful($job);
            }
        }

        return $response;
    }
}
