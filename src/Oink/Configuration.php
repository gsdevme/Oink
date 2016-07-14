<?php

namespace Oink;

use Symfony\Component\Yaml\Yaml;

class Configuration
{
    /**
     * @var string
     */
    private $vagrantFilePath;

    /**
     * @param $yaml
     * @return Configuration
     */
    public static function createFromYaml($yaml)
    {
        $yaml = Yaml::parse($yaml);
        $prefix = '';

        if (isset($yaml['oink'], $yaml['oink']['configuration'])) {
            $directory = str_replace('~', $_SERVER['HOME'], $yaml['oink']['configuration']) . '/';

            $prefix = $directory;
            $file = sprintf('%soink.yml', $directory);

            if (!file_exists($file)) {
                throw new \RuntimeException(sprintf('No oink.yml configuration found in %s', $file));
            }

            $yaml = array_merge($yaml['oink'], Yaml::parse(file_get_contents($file)));
        }

        if (!isset($yaml['oink'], $yaml['oink']['path_to_vagrantfile_location'])) {
            throw new \RuntimeException(sprintf('oink.yml does not appear to have the correct configuration.'));
        }

        $config = array_merge(self::getDefaults(), $yaml['oink']);

        $configuration = new self();
        $configuration->setVagrantFilePath(
            sprintf('%s/%s/', $prefix . $config['path_to_vagrantfile_location'], $config['vm'])
        );

        return $configuration;
    }

    public static function getDefaults()
    {
        return [
            'vm' => 'default',
        ];
    }

    /**
     * @return string
     */
    public function getVagrantFilePath()
    {
        return $this->vagrantFilePath;
    }

    /**
     * @param string $vagrantFilePath
     */
    public function setVagrantFilePath($vagrantFilePath)
    {
        $this->vagrantFilePath = $vagrantFilePath;
    }

}
