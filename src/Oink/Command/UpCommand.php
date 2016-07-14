<?php

namespace Oink\Command;

use Oink\Vagrant\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpCommand extends OinkCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('up');
        $this->setAliases([
            'start'
        ]);
        $this->setDescription('Starts the default VM, (creates if required)');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $vagrant = new Command($this->configuration->getVagrantFilePath());
        $vagrant->doCommand('up', $output);
    }
}
