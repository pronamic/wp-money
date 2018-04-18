<?php

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

require $_tests_dir . '/includes/bootstrap.php';

require_once __DIR__ . '/../vendor/autoload.php';

$money = new \Pronamic\WordPress\Money\Money( 49.75, 'EUR' );

$money->format_i18n();
