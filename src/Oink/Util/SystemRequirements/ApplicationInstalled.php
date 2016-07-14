<?php

namespace Oink\Util\SystemRequirements;

use Symfony\Component\Process\Process;

class ApplicationInstalled
{
    /**
     * @var string
     */
    private $name;

    /**
     * ApplicationInstalled constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isInstalled()
    {
        $process = new Process(sprintf('whereis %s', escapeshellarg($this->name)));
        $process->setTimeout(1);
        $process->run();

        return $process->getExitCode() === 0;
    }
}
