<?php

namespace CronBundle\Tests\Application\Command;

use CronBundle\Application\Command\ScheduleJobsUseCase;
use CronBundle\Domain\Models\Collection\JobCollection;
use CronBundle\Domain\Models\Factory\JobFactory;
use CronBundle\Domain\Service\SchedulerService;
use PHPUnit\Framework\TestCase;

class ScheduleJobsUseCaseTest extends TestCase
{
    /**
     * @group CronBundle
     */
    public function testExecuteWithJobs(): void
    {
        $schedulerService = $this->createMock(SchedulerService::class);

        $testJob = JobFactory::build(
            'CommandTest',
            ['test'],
            '8 * * * *'
        );

        $testJob->setOutput('OK');
        $testJob->setOutputCode(0);

        $schedulerService->expects($this->once())
            ->method('processJob')
            ->willReturn($testJob);

        $scheduleJobsUseCase = new ScheduleJobsUseCase($schedulerService);

        $jobWithErrorsResponse = $scheduleJobsUseCase->execute(
            new JobCollection(
                [
                    $testJob
              ]
            )
        );

        $this->assertCount(0, $jobWithErrorsResponse->getJobErrors());
    }

    /**
     * @group CronBundle
     */
    public function testExecuteWithoutJobs(): void
    {
        $schedulerService = $this->createMock(SchedulerService::class);

        $scheduleJobsUseCase = new ScheduleJobsUseCase($schedulerService);

        $jobWithErrorsResponse = $scheduleJobsUseCase->execute(
            new JobCollection(
                []
            )
        );

        $this->assertCount(0, $jobWithErrorsResponse->getJobErrors());
    }
}
