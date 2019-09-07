<?php

use App\Application;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return static function (Application $app) {
    $app->addRoutingMiddleware();
    $app->addErrorMiddleware($app->getEnvironment() === 'dev', true, true);
    $app->add(TwigMiddleware::createFromContainer($app, Twig::class));
};
