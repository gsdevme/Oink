<?php

namespace Oink\Subscriber;

use Oink\Util\SystemRequirements\ApplicationInstalled;
use Oink\Util\SystemRequirements\ApplicationVersion;
use Oink\Util\SystemRequirements\SuccessfulReturnCode;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SystemRequirementsSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            ConsoleEvents::COMMAND => [
                ['checkRuby', 100],
                ['checkVagrant', 200],
                ['checkBundler', 200],
                ['checkVirtualBox', 500],
                ['checkVagrantHostPlugin', 600]
            ]
        ];
    }

    public function checkVagrant()
    {
        if (!(new ApplicationInstalled('vagrant'))->isInstalled()) {
            throw new \RuntimeException(sprintf('Vagrant does not appear to be installed. https://releases.hashicorp.com/vagrant/1.8.3/vagrant_1.8.3.dmg'));
        }

        if (!(new ApplicationVersion('vagrant'))->isVersion('1.8.1', '1.8.3')) {
            throw new \RuntimeException(sprintf('Vagrant version must be between %s and %s.', '1.8.1', '1.8.3'));
        }
    }

    public function checkRuby()
    {
        if (!(new ApplicationInstalled('ruby'))->isInstalled()) {
            throw new \RuntimeException(sprintf('Ruby does not appear to be installed.'));
        }

        if (!(new ApplicationVersion('ruby'))->isVersion('2.0')) {
            throw new \RuntimeException(sprintf('Ruby version must be at least %s', '2.0'));
        }
    }

    public function checkBundler()
    {
        if (!(new ApplicationInstalled('bundler'))->isInstalled()) {
            throw new \RuntimeException(sprintf('bundler does not appear to be installed with `gem install bundler`'));
        }
    }

    public function checkVirtualBox()
    {
        if (!is_dir('/Applications/VirtualBox.app/')) {
            throw new \RuntimeException(sprintf('Virtualbox does not appear to be installed'));
        }
    }

    public function checkVagrantHostPlugin()
    {
        if (!(new SuccessfulReturnCode())->run('vagrant plugin list | grep vagrant-hostsupdater')) {
            throw new \RuntimeException(
                sprintf('Vagrant plugin is missing, please install `vagrant plugin install vagrant-hostsupdater`')
            );
        }
    }

}
