<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', $_ENV['YII_DEBUG']);
defined('YII_ENV') or define('YII_ENV', $_ENV['YII_ENV']);

defined('DB_HOST') or define('DB_HOST', $_ENV['MYSQL_INTERNAL_IP']);
defined('DB_NAME') or define('DB_NAME', $_ENV['DB_NAME']);
defined('DB_USER') or define('DB_USER', $_ENV['DB_USER']);
defined('DB_PASS') or define('DB_PASS', $_ENV['DB_PASS']);
defined('DOCKER_LOCAL_IP') or define('DOCKER_LOCAL_IP', $_ENV['DOCKER_LOCAL_IP']);