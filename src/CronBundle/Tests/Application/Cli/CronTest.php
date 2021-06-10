<?php

namespace CronBundle\Tests\Application\Cli;

use CronBundle\Application\Cli\Cron;
use CronBundle\Application\Command\ImportJobsUseCase;
use CronBundle\Application\Command\Reponse\ScheduleJobsUseCaseResponse;
use CronBundle\Application\Command\ScheduleJobsUseCase;
use CronBundle\Domain\Models\Collection\JobCollection;
use CronBundle\Domain\Models\Factory\JobFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class CronTest extends TestCase
{
    public function testExecuteCommandSuccessful(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $importJobsUseCase = $this->createMock(ImportJobsUseCase::class);
        $scheduleJobsUseCase = $this->createMock(ScheduleJobsUseCase::class);

        $logger->expects($this->exactly(3))
            ->method('info');

        $importJobsUseCase->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(new JobCollection()));

        $response = new ScheduleJobsUseCaseResponse();

        $job = JobFactory::build(
            '/success',
            [],
            '4 * * * *'
        );

        $job->setOutputCode(0);
        $job->setOutput('Success');

        $response->addJobSuccessful(
            $job
        );

        $scheduleJobsUseCase->expects($this->any())
            ->method('execute')
            ->will($this->returnValue($response));
        $cron = new Cron(
            $logger,
            $importJobsUseCase,
            $scheduleJobsUseCase
        );

        $cron->run(false);
    }

    public function testExecuteCommandWithErrorJob(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $importJobsUseCase = $this->createMock(ImportJobsUseCase::class);
        $scheduleJobsUseCase = $this->createMock(ScheduleJobsUseCase::class);

        $logger->expects($this->exactly(2))
            ->method('info');

        $logger->expects($this->exactly(1))
            ->method('error');

        $importJobsUseCase->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(new JobCollection()));

        $response = new ScheduleJobsUseCaseResponse();

        $job = JobFactory::build(
            '/error',
            [],
            '4 * * * *'
        );

        $job->setOutputCode(1);
        $job->setOutput('Error');

        $response->addJobError(
            $job
        );

        $scheduleJobsUseCase->expects($this->any())
            ->method('execute')
            ->will($this->returnValue($response));

        $cron = new Cron(
            $logger,
            $importJobsUseCase,
            $scheduleJobsUseCase
        );

        $cron->run(false);
    }
}
