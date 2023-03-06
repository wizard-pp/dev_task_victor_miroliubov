<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../docker/');
$env = $dotenv->load();

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', $env['YII_DEBUG']);
defined('YII_ENV') or define('YII_ENV', $env['YII_ENV']);
defined('DB_HOST') or define('DB_HOST', $env['DB_HOST']);
defined('DB_NAME') or define('DB_NAME', $env['DB_NAME']);
defined('DB_USER') or define('DB_USER', $env['DB_USER']);
defined('DB_PASS') or define('DB_PASS', $env['DB_PASS']);
defined('DOCKER_LOCAL_IP') or define('DOCKER_LOCAL_IP', $env['DOCKER_LOCAL_IP']);

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
