<?php

namespace Oink\Command;

use Oink\Configuration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class OinkCommand extends Command
{
    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('build');
    }

    /**
     * @inheritDoc
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->configuration = $this->getApplication()->getConfiguration();
        return parent::run($input, $output);
    }
}
