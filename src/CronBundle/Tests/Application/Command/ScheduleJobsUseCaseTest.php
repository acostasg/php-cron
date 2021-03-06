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

    /**
     * @group CronBundle
     */
    public function testExecuteJobsAndRunning(): void
    {
        $schedulerService = $this->createMock(SchedulerService::class);

        $testJob = JobFactory::build(
            'CommandTest',
            ['test'],
            '8 * * * *'
        );

        $testJob->setOutput('OK');
        $testJob->setExecutionDateTime(new \DateTime('now'));
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
        $this->assertCount(1, $jobWithErrorsResponse->getsuccessfulJobs());
    }

    /**
     * @group CronBundle
     */
    public function testExecuteJobsAndRunningSuccesAndError(): void
    {
        $schedulerService = $this->createMock(SchedulerService::class);

        $testJobSuccess = JobFactory::build(
            'CommandTest',
            ['test'],
            '8 * * * *'
        );

        $testJobSuccess->setOutput('OK');
        $testJobSuccess->setExecutionDateTime(new \DateTime('now'));
        $testJobSuccess->setOutputCode(0);

        $testJobError = JobFactory::build(
            'CommandTest',
            ['test'],
            '8 * * * *'
        );

        $testJobError->setOutput('KO');
        $testJobError->setExecutionDateTime(new \DateTime('now'));
        $testJobError->setOutputCode(1);

        $schedulerService->expects($this->any())
            ->method('processJob')
            ->willReturn($testJobSuccess, $testJobError);

        $scheduleJobsUseCase = new ScheduleJobsUseCase($schedulerService);

        $jobWithErrorsResponse = $scheduleJobsUseCase->execute(
            new JobCollection(
                [
                    $testJobSuccess,
                    $testJobSuccess
                ]
            )
        );

        $this->assertCount(1, $jobWithErrorsResponse->getJobErrors());
        $this->assertCount(1, $jobWithErrorsResponse->getsuccessfulJobs());
    }

    /**
     * @group CronBundle
     */
    public function testExecuteJobsAndRunningError(): void
    {
        $schedulerService = $this->createMock(SchedulerService::class);

        $testJobError = JobFactory::build(
            'CommandTest',
            ['test'],
            '8 * * * *'
        );

        $testJobError->setOutput('KO');
        $testJobError->setExecutionDateTime(new \DateTime('now'));
        $testJobError->setOutputCode(1);

        $schedulerService->expects($this->any())
            ->method('processJob')
            ->willReturn($testJobError);

        $scheduleJobsUseCase = new ScheduleJobsUseCase($schedulerService);

        $jobWithErrorsResponse = $scheduleJobsUseCase->execute(
            new JobCollection(
                [
                    $testJobError
                ]
            )
        );

        $this->assertCount(1, $jobWithErrorsResponse->getJobErrors());
        $this->assertCount(0, $jobWithErrorsResponse->getsuccessfulJobs());
    }
}
