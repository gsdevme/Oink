<?php

namespace Oink\Util\SystemRequirements;

use Symfony\Component\Process\Process;

class ApplicationVersion
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $syntax;

    /**
     * ApplicationVersion constructor.
     * @param $name
     * @param string $syntax
     */
    public function __construct($name, $syntax = '-v')
    {
        $this->name = $name;
        $this->syntax = $syntax;
    }

    /**
     * @param $least
     * @param null $max
     * @return bool
     */
    public function isVersion($least, $max = null)
    {
        $process = new Process(sprintf('%s %s', $this->name, $this->syntax));
        $process->setTimeout(1);
        $process->run();

        if (!$process->isSuccessful()) {
            return false;
        }

        if (preg_match('/\d+(?:\.\d+)+/', $process->getOutput(), $matches)) {
            if ($max == null && version_compare($matches[0], $least, '>=')) {
                return true;
            }

            if (version_compare($matches[0], $max, '<=') && version_compare($matches[0], $least, '>=')) {
                return true;
            }
        }

        return false;
    }
}
