<?php


namespace CronBundle\Infrastucture\Repository\Handler;

use CronBundle\Domain\Repository\Exception\JobsNotFoundException;
use Exception;

class FileCronHandler implements FileHandler
{

    /**
     * @param string $path
     * @param string $nameFile
     * @return String[]
     * @throws JobsNotFoundException
     */
    public function loadFile(string $path, string $nameFile): array
    {
        try {
            $lines =  file(trim($path.$nameFile));
            if (is_array($lines)) {
                return $lines;
            }
            throw new JobsNotFoundException('Empty file cron');
        } catch (Exception $e) {
            throw new JobsNotFoundException($e->getMessage());
        }
    }
}
