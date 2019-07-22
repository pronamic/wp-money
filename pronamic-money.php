<?php
/**
 * Plugin Name: Pronamic Money
 * Plugin URI: https://www.pronamic.eu/plugins/pronamic-money/
 * Description: WordPress Money library.
 *
 * Version: 1.2.2
 * Requires at least: 4.7
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
 * @copyright 2005-2019 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

/**
 * Pronamic Money load plugin textdomain.
 */
function pronamic_money_load_plugin_textdomain() {
	load_plugin_textdomain( 'pronamic-money', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action( 'init', 'pronamic_money_load_plugin_textdomain' );
add_action( 'change_locale', 'pronamic_money_load_plugin_textdomain' );
