<?php


namespace CronBundle\Infrastucture\Repository\Service;

use CronBundle\Domain\Models\Job;
use CronBundle\Domain\Service\ExecuteCommand;

class TerminalExecuteCommandService implements ExecuteCommand
{

    /**
     * @param Job $job
     * @return Job
     */
    public function exec(Job $job): Job
    {
        $output = [];
        $exitCode = 0;
        exec($job->getCommand() . ' ' . implode(" ", $job->getArguments()), $output, $exitCode);
        $job->setExecutionDateTime(new \DateTime("now"));
        $job->setOutputCode($exitCode);
        $job->setOutput(implode(";", $output));
        return $job;
    }
}
