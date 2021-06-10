<?php


namespace CronBundle\Infrastucture\Repository\Handler;

use CronBundle\Domain\Repository\Exception\JobsNotFoundException;

interface FileHandler
{
    /**
     * @param string $path
     * @param string $nameFile
     * @return string[]
     * @throws JobsNotFoundException
     */
    public function loadFile(string $path, string $nameFile): array;
}
