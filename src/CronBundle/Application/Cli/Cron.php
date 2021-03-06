<?php


namespace CronBundle\Application\Cli;

use CronBundle\Application\Command\ImportJobsUseCase;
use CronBundle\Application\Command\ScheduleJobsUseCase;
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


    public function run(bool $daemonMode = true): void
    {
        $this->logger->info('Load jobs from repository');
        $jobCollection = $this->importJobsUseCase->execute();
        $this->logger->info('Execute schedule and running service (Control+C to finish).');

        while (true) {
            $response = $this->scheduleJobsUseCase->execute($jobCollection);


            if (!$response->getJobErrors()->isEmpty()) {
                foreach ($response->getJobErrors() as $jobError) {
                    $this->logger->error($jobError->getCommand() . ' output error: ' . $jobError->getOutput());
                }
            }

            if (!$response->getsuccessfulJobs()->isEmpty()) {
                foreach ($response->getsuccessfulJobs() as $jobError) {
                    $this->logger->info($jobError->getCommand() . ' output successful: ' . $jobError->getOutput());
                }
            }

            if (!$daemonMode) {
                return;
            }

            sleep(1);
        }
    }
}
