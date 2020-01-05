<?php

use App\Application;
use Slim\Csrf\Guard;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return static function (Application $app) {
    $app->addRoutingMiddleware();
    $app->add(new Guard($app->getResponseFactory()));
    $app->addErrorMiddleware($app->getEnvironment() === 'dev', true, true);
    $app->add(TwigMiddleware::createFromContainer($app, Twig::class));
};
