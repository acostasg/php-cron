<?php

namespace CronBundle\Tests\Application\Command;

use CronBundle\Application\Command\ImportJobsUseCase;
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
}
