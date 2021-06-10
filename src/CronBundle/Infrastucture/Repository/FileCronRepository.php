<?php


namespace CronBundle\Infrastucture\Repository;

use Cron\CronExpression;
use Cron\FieldFactory;
use CronBundle\Domain\Models\Collection\JobCollection;
use CronBundle\Domain\Models\Factory\JobFactory;
use CronBundle\Domain\Repository\CronJobsRepository;
use CronBundle\Domain\Repository\Exception\JobsNotFoundException;
use CronBundle\Infrastucture\Repository\Handler\FileHandler;
use CronBundle\Infrastucture\Repository\Handler\FileParserHandler;

class FileCronRepository implements CronJobsRepository
{
    /** @TODO use config file */
    const DIRECTORY = __dir__ . "/CronFiles/";
    const FILE_NAME = "crontab";

    /**
     * @var FileHandler
     */
    private FileHandler $cronHandler;

    /**
     * @var FileParserHandler
     */
    private FileParserHandler $fileParserHandler;

    /**
     * @var JobCollection
     */
    private JobCollection $jobCollection;

    /**
     * FileCronRepository constructor.
     * @param FileHandler $cronHandler
     * @param FileParserHandler $fileParserHandler
     */
    public function __construct(
        FileHandler $cronHandler,
        FileParserHandler $fileParserHandler
    ) {
        $this->cronHandler = $cronHandler;
        $this->fileParserHandler = $fileParserHandler;
        $this->jobCollection = new JobCollection();
    }


    /**
     * @return JobCollection
     * @throws JobsNotFoundException
     */
    public function getJobs(): JobCollection
    {
        $lines = $this->cronHandler->loadFile(self::DIRECTORY, self::FILE_NAME);

        foreach ($lines as $linea) {
            try {
                $this->fileParserHandler->process($linea);

                $this->jobCollection->add(
                    JobFactory::build(
                        $this->fileParserHandler->getCommand(),
                        $this->fileParserHandler->getArguments(),
                        $this->fileParserHandler->getExpressionCron()
                    )
                );
            } catch (\Exception $e) {
                // linea not processed
                continue;
            }
        }

        return $this->jobCollection;
    }
}
