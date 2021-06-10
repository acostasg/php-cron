<?php


use CronBundle\Application\Service\Logger\LoggerConsole;
use CronBundle\Domain\Repository\CronJobsRepository;
use CronBundle\Domain\Service\ExecuteCommand;
use CronBundle\Infrastucture\Repository\FileCronRepository;
use CronBundle\Infrastucture\Repository\Handler\FileCronParserHandler;
use CronBundle\Infrastucture\Repository\Handler\FileHandler;
use CronBundle\Infrastucture\Repository\Handler\FileCronHandler;
use CronBundle\Infrastucture\Repository\Handler\FileParserHandler;
use CronBundle\Infrastucture\Service\TerminalExecuteCommandService;
use Psr\Log\LoggerInterface;
use function DI\create;
use function DI\get;

return [
    // Bind an interface to an implementation
    FileHandler::class => create(FileCronHandler::class),
    FileParserHandler::class => create(FileCronParserHandler::class),
    CronJobsRepository::class => create(FileCronRepository::class)->constructor(get(FileHandler::class), get(FileParserHandler::class)),
    LoggerInterface::class => create(LoggerConsole::class),
    ExecuteCommand::class => create(TerminalExecuteCommandService::class)
];
