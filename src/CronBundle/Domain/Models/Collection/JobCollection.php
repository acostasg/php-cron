<?php


namespace CronBundle\Domain\Models\Collection;

use CronBundle\Domain\Models\Job;
use Exception;
use Iterator;

class JobCollection implements Iterator
{
    /** @var int  */
    private int $iterator;

    /** @var Job[]  */
    private array $jobs;

    /**
     * ProductCollection constructor.
     * @param Job[] $jobs
     */
    public function __construct(array $jobs = [])
    {
        $this->jobs = $jobs;
        $this->iterator = 0;
    }

    /**
     * @param int $position
     * @return Job
     * @throws Exception
     */
    public function getProduct(int $position): Job
    {
        if (isset($this->jobs[$position])) {
            return $this->jobs[$position];
        }

        throw new Exception('Invalid position');
    }

    /**
     * @return Job
     */
    public function current(): Job
    {
        return $this->jobs[$this->iterator];
    }

    public function next(): void
    {
        $this->iterator++;
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->iterator;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->jobs[$this->iterator]);
    }

    public function rewind(): void
    {
        $this->iterator = 0;
    }
}
