<?php

namespace CronBundle\Tests\Application\Command;

use Cron\CronExpression;
use Cron\FieldFactory;
use CronBundle\Application\Command\ScheduleJobsUseCase;
use CronBundle\Domain\Models\Collection\JobCollection;
use CronBundle\Domain\Models\Factory\JobFactory;
use PHPUnit\Framework\TestCase;

class ScheduleJobsUseCaseTest extends TestCase
{
    /**
     * @group CronBundle
     */
    public function testExecuteWithJobs(): void
    {
        $scheduleJobsUseCase = new ScheduleJobsUseCase();

        $hasPendingJobs = $scheduleJobsUseCase->execute(
            new JobCollection(
                [
                  JobFactory::build(
                      'CommandTest',
                      ['test'],
                      new CronExpression('8 * * * *', new FieldFactory())
                  )
              ]
            )
        );

        $this->assertTrue($hasPendingJobs);
    }

    /**
     * @group CronBundle
     */
    public function testExecuteWithoutJobs(): void
    {
        $scheduleJobsUseCase = new ScheduleJobsUseCase();

        $hasPendingJobs = $scheduleJobsUseCase->execute(
            new JobCollection(
                []
            )
        );

        $this->assertFalse($hasPendingJobs);
    }
}
