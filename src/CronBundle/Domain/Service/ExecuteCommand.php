<?php


namespace CronBundle\Domain\Service;

use CronBundle\Domain\Models\Job;

interface ExecuteCommand
{
    /**
     * @param Job $job
     * @return Job
     */
    public function exec(Job $job): Job;
}
