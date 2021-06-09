<?php


namespace CronBundle\Domain\Models;

abstract class AbstractJob
{


    abstract public function update(): void;

}
