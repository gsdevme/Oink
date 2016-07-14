<?php

namespace Oink\Util\SystemRequirements;

use Symfony\Component\Process\Process;

class SuccessfulReturnCode
{
    /**
     * @param $command
     * @return bool
     */
    public function run($command)
    {
        $process = new Process($command);
        $process->setTimeout(5);
        $process->run();

        return $process->getExitCode() === 0;
    }
}
