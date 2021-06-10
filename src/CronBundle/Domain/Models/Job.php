<?php


namespace CronBundle\Domain\Models;

use Cron\CronExpression;
use DateTime;

class Job
{

    /**
     * Job constructor.
     * @param string $id
     * @param string $command
     * @param String[] $arguments
     * @param DateTime $createdDatetime
     * @param CronExpression $executionDateTime
     */
    public function __construct(
        string $id,
        string $command,
        array $arguments,
        DateTime $createdDatetime,
        CronExpression $executionDateTime
    ) {
        $this->id = $id;
        $this->command = $command;
        $this->arguments = $arguments;
        $this->createdDateime = $createdDatetime;
        $this->executionDateTime = $executionDateTime;
    }

    /**
     * Unique identifier
     *
     * @var string
     */
    private string $id;

    /**
     * Command line to execute
     *
     * @var string
     */
    private string $command;

    /**
     * Arguments for the command
     *
     * @var String[]
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
     * @var CronExpression
     */
    private CronExpression $executionDateTime;

    /**
     * The output of the executed command
     *
     * @var string|null
     */
    private ?string $output = null;

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
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
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
     * @return String[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param String[] $arguments
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    /**
     * @return DateTime
     */
    public function getCreatedDateime(): DateTime
    {
        return $this->createdDateime;
    }

    /**
     * @param DateTime $createdDateime
     */
    public function setCreatedDateime(DateTime $createdDateime): void
    {
        $this->createdDateime = $createdDateime;
    }

    /**
     * @return CronExpression
     */
    public function getExecutionDateTime(): CronExpression
    {
        return $this->executionDateTime;
    }

    /**
     * @param CronExpression $executionDateTime
     */
    public function setExecutionDateTime(CronExpression $executionDateTime): void
    {
        $this->executionDateTime = $executionDateTime;
    }

    /**
     * @return string|null
     */
    public function getOutput(): ?string
    {
        return $this->output;
    }

    /**
     * @param string|null $output
     */
    public function setOutput(?string $output): void
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
     * @param int $outputCode
     */
    public function setOutputCode(int $outputCode): void
    {
        $this->outputCode = $outputCode;
    }
}
