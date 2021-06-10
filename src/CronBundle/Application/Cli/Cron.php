<?php


namespace CronBundle\Application\Cli;

use CronBundle\Application\Command\ImportJobsUseCase;
use CronBundle\Application\Command\ScheduleJobsUseCase;
use CronBundle\Infrastucture\Repository\FileCronRepository;
use CronBundle\Infrastucture\Repository\Handler\FileHandler;
use CronBundle\Infrastucture\Repository\Handler\FileCronHandler;
use Psr\Log\LoggerInterface;

class Cron implements ConsoleInterface
{
    private LoggerInterface $logger;
    private ImportJobsUseCase $importJobsUseCase;
    private ScheduleJobsUseCase $scheduleJobsUseCase;

    /**
     * Cron constructor.
     * @param LoggerInterface $logger
     * @param ImportJobsUseCase $importJobsUseCase
     * @param ScheduleJobsUseCase $scheduleJobsUseCase
     */
    public function __construct(
        LoggerInterface $logger,
        ImportJobsUseCase $importJobsUseCase,
        ScheduleJobsUseCase $scheduleJobsUseCase
    ) {
        $this->logger = $logger;
        $this->importJobsUseCase = $importJobsUseCase;
        $this->scheduleJobsUseCase = $scheduleJobsUseCase;
    }


    public function run(): void
    {
        $this->logger->info('Load jobs from repository');
        $jobCollection = $this->importJobsUseCase->execute();
        $this->logger->info('Execute schedule and running service (Control+C to finish).');

        $existJobs = true;
        while ($existJobs) {
            $existJobs = $this->scheduleJobsUseCase->execute($jobCollection);
            sleep(1);
        }

        $this->logger->info('Finish!!! Not Jobs pending to execute (Control+C to finish).');
    }
}
