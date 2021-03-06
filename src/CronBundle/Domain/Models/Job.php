<?php


namespace CronBundle\Domain\Models;

use CronBundle\Domain\Repository\Exception\InvalidJobData;
use CronBundle\Domain\ValueObject\Expression;
use CronBundle\Domain\ValueObject\JobId;
use DateTime;

class Job
{

    /**
     * Unique identifier
     *
     * @var JobId
     */
    private JobId $id;

    /**
     * Command line to execute
     *
     * @var string
     */
    private string $command;

    /**
     * Arguments for the command
     *
     * @var string[]
     */
    private array $arguments = [];

    /**
     * Date Time to created job
     *
     * @var DateTime
     */
    private DateTime $createdDateime;

    /**
     * Date time to process command
     *
     * @var DateTime
     */
    private ?DateTime $executionDateTime = null;

    /**
     * Date time to process command
     *
     * @var Expression
     */
    private Expression $cronExpression;

    /**
     * The output of the executed command
     *
     * @var string
     */
    private string $output = '';

    /**
     * The output code of the command
     *
     * @var int
     */
    private int $outputCode = 0;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id->getValue();
    }

    /**
     * @param JobId $id
     */
    public function setId(JobId $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @param string $command
     */
    public function setCommand(string $command): void
    {
        $this->command = $command;
    }

    /**
     * @return string[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param string[] $arguments
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    /**
     * @return DateTime
     */
    public function getCreatedDatetime(): DateTime
    {
        return $this->createdDateime;
    }

    /**
     * @param DateTime $createdDatetime
     */
    public function setCreatedDatetime(DateTime $createdDatetime): void
    {
        $this->createdDateime = $createdDatetime;
    }

    /**
     * @return ?DateTime
     */
    public function getExecutionDateTime(): ?DateTime
    {
        return $this->executionDateTime;
    }

    /**
     * @param DateTime $executionDateTime
     */
    public function setExecutionDateTime(DateTime $executionDateTime): void
    {
        $this->executionDateTime = $executionDateTime;
    }

    /**
     * @return string
     */
    public function getOutput(): string
    {
        return $this->output;
    }

    /**
     * @param string $output
     */
    public function setOutput(string $output): void
    {
        $this->output = $output;
    }

    /**
     * @return int
     */
    public function getOutputCode(): int
    {
        return $this->outputCode;
    }

    /**
     * @return bool
     */
    public function isFailExecuted(): bool
    {
        return ($this->outputCode > 0);
    }

    /**
     * @return bool
     */
    public function isSuccessExecuted(): bool
    {
        return ($this->executionDateTime!= null and $this->outputCode == 0);
    }

    /**
     * @param int $outputCode
     */
    public function setOutputCode(int $outputCode): void
    {
        $this->outputCode = $outputCode;
    }

    /**
     * @return Expression
     */
    public function getExpression(): Expression
    {
        return $this->cronExpression;
    }


    /**
     * Job constructor.
     * @param JobId $id
     * @param string $command
     * @param string[] $arguments
     * @param DateTime $createdDatetime
     * @param Expression $cronExpression
     * @throws InvalidJobData
     */
    public function __construct(
        JobId $id,
        string $command,
        array $arguments,
        DateTime $createdDatetime,
        Expression $cronExpression
    ) {
        if (empty($command)) {
            throw new InvalidJobData("Empty command is no valid job");
        }
        $this->id = $id;
        $this->command = $command;
        $this->arguments = $arguments;
        $this->createdDateime = $createdDatetime;
        $this->cronExpression = $cronExpression;
    }
}
