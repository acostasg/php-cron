<?php

namespace CronBundle\Tests\Infrastucture\Repository\Handler;

use CronBundle\Domain\Repository\Exception\InvalidJobData;
use CronBundle\Infrastucture\Repository\Handler\FileCronParserHandler;
use PHPUnit\Framework\TestCase;

class FileCronParserHandlerTest extends TestCase
{

    /**
     * Data provider for testValidatePredefined.
     *
     * @return array[]
     */
    public static function getMappingToPredefined(): array
    {
        return array(
            ['@hourly', '0 * * * *'],
            ['@daily', '0 0 * * *'],
            ['@weekly', '0 0 * * 0'],
            ['@monthly', '0 0 1 * *'],
            ['@yearly', '0 0 1 1 *'],
            ['@annually', '0 0 1 1 *'],
            ['@always', '* * * * *'],
            ['@5minutes', '*/5 * * * *'],
            ['@10minutes', '*/10 * * * *'],
            ['@15minutes', '*/15 * * * *'],
            ['@30minutes', '0,30 * * * *']
        );
    }


    /**
     * @dataProvider getMappingToPredefined
     * @param string $value
     * @param string $expected
     * @throws InvalidJobData
     */
    public function testValidatePredefined(string $value, string $expected): void
    {
        $fileCronParserHandler = new FileCronParserHandler();

        $fileCronParserHandler->process($value . ' /validCommand arg1 arg2');
        $this->assertEquals($expected, $fileCronParserHandler->getExpressionCron());
    }

    public function testValidCommand(): void
    {
        $fileCronParserHandler = new FileCronParserHandler();

        $fileCronParserHandler->process('4 * * * * /validCommand arg1 arg2');
        $this->assertEquals('/validCommand', $fileCronParserHandler->getCommand());
    }

    public function testValidParams(): void
    {
        $fileCronParserHandler = new FileCronParserHandler();

        $fileCronParserHandler->process('4 * * * * /validCommand arg1 arg2');
        $this->assertEquals(['arg1','arg2'], $fileCronParserHandler->getArguments());
    }

    /**
     * Data provider for testValidateLiterals.
     *
     * @return array[]
     */
    public function getMappingLiterals(): array
    {
        return [
            ['sun' , 0],
            ['mon' , 1],
            ['tue' , 2],
            ['wed' , 3],
            ['thu' , 4],
            ['fri' , 5],
            ['sat' , 6],
            ['jan' , 1],
            ['feb' , 2],
            ['mar' , 3],
            ['apr' , 4],
            ['may' , 5],
            ['jun' , 6],
            ['jul' , 7],
            ['aug' , 8],
            ['sep' , 9],
            ['oct' , 10],
            ['nov' , 11],
            ['dec' , 12]
        ];
    }


    /**
     * @dataProvider getMappingLiterals
     * @param string $value
     * @param int $expected
     * @throws InvalidJobData
     */
    public function testValidateLiterals(string $value, int $expected): void
    {
        $fileCronParserHandler = new FileCronParserHandler();

        $fileCronParserHandler->process('0 4,17 * * '. $value . ' /validCommand arg1 arg2');
        $this->assertEquals('0 4,17 * * '.$expected, $fileCronParserHandler->getExpressionCron());
        $this->assertEquals('/validCommand', $fileCronParserHandler->getCommand());
        $this->assertEquals(['arg1', 'arg2'], $fileCronParserHandler->getArguments());
    }


    public function testInvalidExpressionExpression(): void
    {
        $this->expectException(InvalidJobData::class);

        $fileCronParserHandler = new FileCronParserHandler();

        $fileCronParserHandler->process(' /validCommand arg1 arg2');
    }

    public function testInvalidCommandExpression(): void
    {
        $this->expectException(InvalidJobData::class);

        $fileCronParserHandler = new FileCronParserHandler();

        $fileCronParserHandler->process('0 4,17 * * *');
    }
}
