<?php
/**
 * Plugin Name: Pronamic Money
 * Plugin URI: https://www.pronamic.eu/plugins/pronamic-money/
 * Description: WordPress Money library.
 *
 * Version: 2.2.1
 * Requires at least: 4.7
 * Requires PHP: 8.0
 *
 * Author: Pronamic
 * Author URI: https://www.pronamic.eu/
 *
 * Text Domain: pronamic-money
 * Domain Path: /languages/
 *
 * License: GPL-3.0-or-later
 *
 * GitHub URI: https://github.com/pronamic/wp-money
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

/**
 * Pronamic Money load plugin text domain.
 */
function pronamic_money_load_plugin_textdomain() {
	load_plugin_textdomain( 'pronamic-money', false, basename( __DIR__ ) . '/languages' );
}

add_action( 'init', 'pronamic_money_load_plugin_textdomain' );
add_action( 'change_locale', 'pronamic_money_load_plugin_textdomain' );
