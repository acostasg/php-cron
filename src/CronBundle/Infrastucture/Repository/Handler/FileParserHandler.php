<?php


namespace CronBundle\Infrastucture\Repository\Handler;

use CronBundle\Domain\Repository\Exception\InvalidJobData;

interface FileParserHandler
{


    /**
     * @param string $raw
     * @throws InvalidJobData
     */
    public function process(string $raw): void;

    /**
     * @return string
     */
    public function getCommand(): string;

    /**
     * @return string[]
     */
    public function getArguments(): array;

    /**
     * @return string
     */
    public function getExpressionCron(): string;
}
