<?php

namespace Oink\Subscriber;

use Oink\Application;
use Oink\Configuration;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocateConfiguration implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            ConsoleEvents::COMMAND => [
                ['locateConfiguration', 100]
            ],
        ];
    }

    /**
     * @param ConsoleCommandEvent $commandEvent
     */
    public function locateConfiguration(ConsoleCommandEvent $commandEvent)
    {
        $file = realpath(getcwd()) . '/oink.yml';

        if (!file_exists($file)) {
            throw new \RuntimeException(sprintf('Could not find oink.yml'));
        }

        $configuration = Configuration::createFromYaml(file_get_contents($file));

        $command = $commandEvent->getCommand();

        /** @var Application $application */
        $application = $command->getApplication();
        $application->setConfiguration($configuration);
    }

}
