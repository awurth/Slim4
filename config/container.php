<?php

use App\Application;
use App\Twig\AssetExtension;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

return static function (Application $app, ContainerBuilder $container) {
    $container->addDefinitions([
        LoggerInterface::class => static function () use ($app) {
            return (new Logger('main'))
                ->pushProcessor(new UidProcessor())
                ->pushHandler(new StreamHandler($app->getLogsDir().'/'.$app->getEnvironment().'.log', Logger::DEBUG));
        },
        Twig::class => static function () use ($app) {
            $twig = Twig::create($app->getProjectDir().'/templates', [
                'cache' => $app->getCacheDir().'/twig',
                'debug' => $app->getEnvironment() !== 'prod'
            ]);

            $twig->addExtension(new AssetExtension($app->getBasePath()));

            return $twig;
        }
    ]);
};
