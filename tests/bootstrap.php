<?php

require_once __DIR__ . '/../vendor/autoload.php';

if ( is_readable( '.env' ) ) {
	$dotenv = new Dotenv\Dotenv( __DIR__ );
	$dotenv->load();
}

require_once getenv( 'WP_PHPUNIT__DIR' ) . '/includes/functions.php';

function _manually_load_plugin() {
	require __DIR__ . '/../pronamic-money.php';
}

tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require getenv( 'WP_PHPUNIT__DIR' ) . '/includes/bootstrap.php';
