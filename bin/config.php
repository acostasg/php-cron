<?php


use CronBundle\Application\Service\Logger\LoggerConsole;
use CronBundle\Domain\Repository\CronJobsRepository;
use CronBundle\Infrastucture\Repository\FileCronRepository;
use Psr\Log\LoggerInterface;
use function DI\create;

return [
    // Bind an interface to an implementation
    CronJobsRepository::class => create(FileCronRepository::class),
    LoggerInterface::class => create(LoggerConsole::class)
];
