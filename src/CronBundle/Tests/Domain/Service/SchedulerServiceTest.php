<?php

namespace CronBundle\Tests\Domain\Service;

use CronBundle\Domain\Models\Factory\JobFactory;
use CronBundle\Domain\Service\ExecuteCommand;
use CronBundle\Domain\Service\SchedulerService;
use PHPUnit\Framework\TestCase;

class SchedulerServiceTest extends TestCase
{
    public function testExecuteJob(): void
    {
        $executeCommand = $this->createMock(ExecuteCommand::class);

        $job = JobFactory::build(
            '/ls',
            ['param'],
            '* * * * *'
        );

        $executeCommand->expects($this->once())
            ->method('exec')
            ->willReturn($job);


        $jobResult = (new SchedulerService($executeCommand))->processJob($job);

        $this->assertEquals($job->getId(), $jobResult->getId());
    }

    public function textNotExecuteJob(): void
    {
        $executeCommand = $this->createMock(ExecuteCommand::class);

        $job = JobFactory::build(
            '/ls',
            ['param'],
            '0 0 0 0 0'
        );

        $executeCommand->expects($this->never())
            ->method('exec')
            ->willReturn($job);


        $jobResult = (new SchedulerService($executeCommand))->processJob($job);

        $this->assertEquals($job->getId(), $jobResult->getId());
    }
}
