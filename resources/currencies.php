<?php
/**
 * Currencies
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2018 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

/**
 * Currencies
 *
 * @link https://github.com/moneyphp/money/blob/v3.1.3/src/Currencies/ISOCurrencies.php#L90-L102
 * @link https://github.com/moneyphp/money/blob/v3.1.3/resources/currency.php
 *
 * @author Remco Tolsma
 * @version 1.0
 */
return array(
	array(
		'alphabetic_code' => 'EUR',
		'numeric_code'    => '978',
		'name'            => __( 'Euro', 'pronamic-money' ),
		'symbol'          => '€',
		'number_decimals' => 2,
	),
	array(
		'alphabetic_code' => 'NLG',
		'numeric_code'    => null,
		'name'            => __( 'Gulden', 'pronamic-money' ),
		'symbol'          => 'G',
		'number_decimals' => 4,
	),
	array(
		'alphabetic_code' => 'GBP',
		'numeric_code'    => '826',
		'name'            => __( 'Pound Sterling', 'pronamic-money' ),
		'symbol'          => '£',
		'number_decimals' => 2,
	),
	array(
		'alphabetic_code' => 'USD',
		'numeric_code'    => '840',
		'name'            => __( 'US Dollar', 'pronamic-money' ),
		'symbol'          => '$',
		'number_decimals' => 2,
	),
	array(
		'alphabetic_code' => 'AUD',
		'numeric_code'    => '036',
		'name'            => __( 'Australian Dollar', 'pronamic-money' ),
		'symbol'          => '$',
		'number_decimals' => 2,
	),
);
