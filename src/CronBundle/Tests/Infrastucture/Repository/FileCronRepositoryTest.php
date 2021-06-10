<?php

namespace CronBundle\Tests\Infrastucture\Repository;

use CronBundle\Infrastucture\Repository\FileCronRepository;
use CronBundle\Infrastucture\Repository\Handler\FileHandler;
use CronBundle\Infrastucture\Repository\Handler\FileParserHandler;
use PHPUnit\Framework\TestCase;

class FileCronRepositoryTest extends TestCase
{
    const EXPRESSION_TEST = '8 * * * *';
    const WRONG_EXPRESSION_TEST = '8 h 0 0 0';
    const ARGUMENTS_TEST = ['param', 'param'];
    const COMMAND_TEST = './test.sh';

    /**
     * @group CronBundle
     */
    public function testCorrectLineaWithArguments(): void
    {
        $fileHandler = $this->createMock(FileHandler::class);
        $fileParserHandler = $this->createMock(FileParserHandler::class);

        $fileHandler->expects($this->once())
            ->method('loadFile')
            ->willReturn(['Ignore text']);

        $fileParserHandler->expects($this->once())
            ->method('process');

        $fileParserHandler->expects($this->once())
            ->method('getCommand')
            ->willReturn(self::COMMAND_TEST);

        $fileParserHandler->expects($this->once())
            ->method('getArguments')
            ->willReturn(self::ARGUMENTS_TEST);

        $fileParserHandler->expects($this->once())
            ->method('getExpressionCron')
            ->willReturn(self::EXPRESSION_TEST);


        $fileCronRepository = new FileCronRepository(
            $fileHandler,
            $fileParserHandler
        );

        $jobCollection = $fileCronRepository->getJobs();

        $this->assertCount(1, $jobCollection);
        $this->assertEquals(self::COMMAND_TEST, $jobCollection->get(0)->getCommand());
        $this->assertEquals(self::ARGUMENTS_TEST, $jobCollection->get(0)->getArguments());
        $this->assertEquals(self::EXPRESSION_TEST, $jobCollection->get(0)->expression()->getExpression());
    }

    /**
     * @group CronBundle
     */
    public function testCorrectLineaWithoutArguments(): void
    {
        $fileHandler = $this->createMock(FileHandler::class);
        $fileParserHandler = $this->createMock(FileParserHandler::class);

        $fileHandler->expects($this->once())
            ->method('loadFile')
            ->willReturn(['Ignore text']);

        $fileParserHandler->expects($this->once())
            ->method('process');

        $fileParserHandler->expects($this->once())
            ->method('getCommand')
            ->willReturn(self::COMMAND_TEST);

        $fileParserHandler->expects($this->once())
            ->method('getArguments')
            ->willReturn([]);

        $fileParserHandler->expects($this->once())
            ->method('getExpressionCron')
            ->willReturn(self::EXPRESSION_TEST);


        $fileCronRepository = new FileCronRepository(
            $fileHandler,
            $fileParserHandler
        );

        $jobCollection = $fileCronRepository->getJobs();

        $this->assertCount(1, $jobCollection);
        $this->assertEquals(self::COMMAND_TEST, $jobCollection->get(0)->getCommand());
        $this->assertEquals([], $jobCollection->get(0)->getArguments());
        $this->assertEquals(self::EXPRESSION_TEST, $jobCollection->get(0)->expression()->getExpression());
    }

    /**
     * @group CronBundle
     */
    public function testWrongCronExpressionInLinea(): void
    {
        $fileHandler = $this->createMock(FileHandler::class);
        $fileParserHandler = $this->createMock(FileParserHandler::class);

        $fileHandler->expects($this->once())
            ->method('loadFile')
            ->willReturn(['Ignore text']);

        $fileParserHandler->expects($this->once())
            ->method('process');

        $fileParserHandler->expects($this->once())
            ->method('getCommand')
            ->willReturn(self::COMMAND_TEST);

        $fileParserHandler->expects($this->once())
            ->method('getArguments')
            ->willReturn(self::ARGUMENTS_TEST);

        $fileParserHandler->expects($this->once())
            ->method('getExpressionCron')
            ->willReturn(self::WRONG_EXPRESSION_TEST);


        $fileCronRepository = new FileCronRepository(
            $fileHandler,
            $fileParserHandler
        );

        $jobCollection = $fileCronRepository->getJobs();

        $this->assertCount(0, $jobCollection);
    }

    /**
     * @group CronBundle
     */
    public function testWrongCommandInLinea(): void
    {
        $fileHandler = $this->createMock(FileHandler::class);
        $fileParserHandler = $this->createMock(FileParserHandler::class);

        $fileHandler->expects($this->once())
            ->method('loadFile')
            ->willReturn(['Ignore text']);

        $fileParserHandler->expects($this->once())
            ->method('process');

        $fileParserHandler->expects($this->once())
            ->method('getCommand')
            ->willReturn('');

        $fileParserHandler->expects($this->once())
            ->method('getArguments')
            ->willReturn(self::ARGUMENTS_TEST);

        $fileParserHandler->expects($this->once())
            ->method('getExpressionCron')
            ->willReturn(self::EXPRESSION_TEST);


        $fileCronRepository = new FileCronRepository(
            $fileHandler,
            $fileParserHandler
        );

        $jobCollection = $fileCronRepository->getJobs();

        $this->assertCount(0, $jobCollection);
    }
}
