<?php

namespace CronBundle\Tests\Application\Command;

use CronBundle\Application\Command\ImportJobsUseCase;
use CronBundle\Domain\Models\Collection\JobCollection;
use CronBundle\Domain\Repository\CronJobsRepository;
use CronBundle\Domain\Repository\Exception\JobsNotFoundException;
use CronBundle\Infrastucture\Repository\InMemory\InMemoryFileCronRepository;
use PHPUnit\Framework\TestCase;

class ImportJobsUseCaseTest extends TestCase
{

    /**
     * @group CronBundle
     */
    public function testGetAllJobs(): void
    {
        $importJobsUseCase = new ImportJobsUseCase(
            new InMemoryFileCronRepository()
        );

        $this->assertCount(2, $importJobsUseCase->execute());
    }

    /**
     * @group CronBundle
     */
    public function testNotJobsFound(): void
    {
        $repositoryMock = $this->createMock(CronJobsRepository::class);

        $repositoryMock->expects($this->once())
            ->method('getJobs')
            ->willThrowException(new JobsNotFoundException('Not jobs found'));

        $importJobsUseCase = new ImportJobsUseCase(
            $repositoryMock
        );

        $this->assertCount(0, $importJobsUseCase->execute());
    }
}
