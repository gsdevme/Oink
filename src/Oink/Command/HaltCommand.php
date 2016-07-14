<?php

namespace Oink\Command;

use Oink\Vagrant\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HaltCommand extends OinkCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('halt');
        $this->setAliases([
            'stop'
        ]);
        $this->setDescription('Halt the default VM');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $vagrant = new Command($this->configuration->getVagrantFilePath());
        $vagrant->doCommand('halt', $output);
    }
}
