<?php

use App\Application;
use Symfony\Component\Dotenv\Dotenv;

session_start();

require __DIR__.'/../vendor/autoload.php';

(new Dotenv())->loadEnv(dirname(__DIR__).'/.env');

$app = new Application($_SERVER['APP_ENV']);

$app->run();
