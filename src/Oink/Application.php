<?php

namespace Oink;

use Oink\Command\BuildCommand;
use Oink\Command\HaltCommand;
use Oink\Command\UpCommand;
use Oink\Subscriber\LocateConfiguration;
use Oink\Subscriber\SystemRequirementsSubscriber;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Application extends BaseApplication
{
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct()
    {
        $version = 'beta';

        if (defined('OINK_VERSION')) {
            $version = OINK_VERSION;
        }

        $this->configuration = new Configuration();

        parent::__construct('Oink', $version);

        $this->dispatcher = new EventDispatcher();
        $this->dispatcher->addSubscriber(new LocateConfiguration());
        $this->dispatcher->addSubscriber(new SystemRequirementsSubscriber());

        $this->add(new UpCommand());
        $this->add(new HaltCommand());
        $this->add(new BuildCommand());

        $this->setDispatcher($this->dispatcher);
    }

    /**
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param Configuration $configuration
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }
}
