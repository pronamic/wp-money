<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv( __DIR__ );
$dotenv->load();

require_once getenv( 'WP_PHPUNIT__DIR' ) . '/includes/functions.php';

require getenv( 'WP_PHPUNIT__DIR' ) . '/includes/bootstrap.php';
