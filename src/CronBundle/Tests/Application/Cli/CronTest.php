<?php

namespace CronBundle\Tests\Application\Cli;

use CronBundle\Application\Cli\Cron;
use CronBundle\Application\Command\ImportJobsUseCase;
use CronBundle\Application\Command\ScheduleJobsUseCase;
use CronBundle\Domain\Models\Collection\JobCollection;
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

        $scheduleJobsUseCase->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(false));

        $cron = new Cron(
            $logger,
            $importJobsUseCase,
            $scheduleJobsUseCase
        );

        $cron->run();
    }
}
