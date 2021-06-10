<?php


namespace CronBundle\Domain\ValueObject;

class JobId
{
    private string $value;

    /**
     * JobId constructor.
     * @param string $command
     * @param string[] $arguments
     */
    public function __construct(string $command, array $arguments)
    {
        $this->value = serialize($command.implode(";", $arguments));
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
