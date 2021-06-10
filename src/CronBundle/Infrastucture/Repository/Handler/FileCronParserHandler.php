<?php


namespace CronBundle\Infrastucture\Repository\Handler;

use CronBundle\Domain\Repository\Exception\InvalidJobData;
use function array_keys;
use function array_values;
use function str_ireplace;

class FileCronParserHandler implements FileParserHandler
{
    /**
     * @var string[]
     */
    private array $predefined = array(
        '@hourly'   => '0 * * * *',
        '@daily'    => '0 0 * * *',
        '@weekly'   => '0 0 * * 0',
        '@monthly'  => '0 0 1 * *',
        '@yearly'   => '0 0 1 1 *',
        '@annually' => '0 0 1 1 *',
        '@always'   => '* * * * *',
        '@5minutes' => '*/5 * * * *',
        '@10minutes' => '*/10 * * * *',
        '@15minutes' => '*/15 * * * *',
        '@30minutes' => '0,30 * * * *'
    );


    /**
     * @var int[]
     */
    private array $literals = [
        'sun' => 0,
        'mon' => 1,
        'tue' => 2,
        'wed' => 3,
        'thu' => 4,
        'fri' => 5,
        'sat' => 6,
        'jan' => 1,
        'feb' => 2,
        'mar' => 3,
        'apr' => 4,
        'may' => 5,
        'jun' => 6,
        'jul' => 7,
        'aug' => 8,
        'sep' => 9,
        'oct' => 10,
        'nov' => 11,
        'dec' => 12,
    ];

    /**
     * @var string
     */
    private string $command;

    /**
     * @var string[]
     */
    private array $arguments;

    /**
     * @var string
     */
    private string $expression;

    /**
     * FileCronParserHandler constructor.
     */
    public function __construct()
    {
        $this->command = '';
        $this->arguments = [];
        $this->expression = '';
    }

    /**
     * @param string $raw
     * @throws InvalidJobData
     */
    public function process(string $raw): void
    {
        if (empty($raw) || $raw[0] == '#') {
            throw new InvalidJobData('Line is empty o not start amb caracter #');
        }
        if ($raw[0] == '@') {
            $space = strpos($raw, ' ');
            if ($space === false) {
                throw new InvalidJobData("Unparseable macro line $raw");
            }
            $macro = substr($raw, 0, $space);
            if (!isset($this->predefined[$macro])) {
                throw new InvalidJobData("Unrecognised macro $macro");
            }
            $raw = str_replace($macro, $this->predefined[$macro], $raw);
        }

        /** @var string[] $split */
        $split = preg_split('/\s+/', $raw);

        if (empty($split[5])) {
            throw new InvalidJobData("Not command found");
        }

        $this->command = $split[5];

        if (!empty($split[6])) {
            $this->arguments = array_slice((array)$split, 6);
        }

        $rawExpression = implode(" ", (array_slice((array)$split, 0, 5)));
        $rawExpression = str_ireplace(array_keys($this->literals), array_values($this->literals), $rawExpression);
        $this->expression = $rawExpression;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @return string[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return string
     */
    public function getExpressionCron(): string
    {
        return $this->expression;
    }
}
