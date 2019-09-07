<?php

namespace App;

use DI\ContainerBuilder;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;

class Application extends App
{
    /**
     * @var string
     */
    protected $environment;

    /**
     * @var string
     */
    protected $projectDir;

    public function __construct(string $environment)
    {
        $this->environment = $environment;
        $this->getProjectDir();

        $container = new ContainerBuilder();

        $this->load('container')($this, $container);

        parent::__construct(AppFactory::determineResponseFactory(), $container->build());

        $this->getRouteCollector()->setDefaultInvocationStrategy(new RequestResponseArgs());

        $this->load('middleware')($this);
        $this->load('routes')($this);
    }

    public function getCacheDir(): string
    {
        return $this->getProjectDir().'/var/cache/'.$this->getEnvironment();
    }

    public function getConfigurationDir(): string
    {
        return $this->getProjectDir().'/config';
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function getLogsDir(): string
    {
        return $this->getProjectDir().'/var/log';
    }

    public function getProjectDir(): string
    {
        if (!$this->projectDir) {
            $this->projectDir = dirname(__DIR__);
        }

        return $this->projectDir;
    }

    protected function getConfigFilePath(string $filename): string
    {
        return $this->getConfigurationDir().'/'.$filename.'.php';
    }

    protected function load(string $filename)
    {
        return require $this->getConfigFilePath($filename);
    }
}
