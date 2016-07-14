<?php

namespace Oink\Vagrant;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class Command
{
    private $workingDirectory;

    /**
     * Command constructor.
     * @param $workingDirectory
     */
    public function __construct($workingDirectory)
    {
        $this->workingDirectory = $workingDirectory;
    }

    public function doCommand($command, OutputInterface $output)
    {
        $process = new Process(sprintf('vagrant %s', $command), $this->workingDirectory);
        $process->setTimeout(null);
        $process->enableOutput();
        $process->start();

        foreach ($process as $type => $data) {
            if (Process::ERR === $type) {
                $output->write(sprintf('<comment>%s</comment>', $this->decorateOutput($data)));
            } else {
                $output->write(sprintf('<info>%s</info>', $this->decorateOutput($data)));
            }
        }
    }

    /**
     * @param $output
     * @return mixed
     */
    private function decorateOutput($output)
    {
        $output = str_replace('==> default:', '=> oink:', $output);
        $output = str_replace('    default:', '=> oink:', $output);

        return $output;
    }
}
