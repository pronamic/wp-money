<?php
/**
 * Currencies
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2019 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

/**
 * Currencies
 *
 * @link https://github.com/moneyphp/money/blob/v3.1.3/resources/currency.php
 *
 * @author  Remco Tolsma
 * @version 1.2.2
 * @since   1.0.0
 */
class Currencies {
	/**
	 * Map of known currencies indexed by code.
	 *
	 * @var array|null
	 */
	private static $currencies;

	/**
	 * Get currencies.
	 *
	 * @return array
	 */
	public static function get_currencies() {
		if ( is_null( self::$currencies ) ) {
			self::$currencies = self::load_currencies();
		}

		return self::$currencies;
	}

	/**
	 * Get currency.
	 *
	 * @param string $alphabetic_code Alphabetic currency code.
	 *
	 * @return Currency
	 */
	public static function get_currency( $alphabetic_code ) {
		$currency = new Currency();

		$currencies = self::get_currencies();

		if ( isset( $currencies[ $alphabetic_code ] ) ) {
			$currency = $currencies[ $alphabetic_code ];
		}

		return $currency;
	}

	/**
	 * Load currencies.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.1.3/src/Currencies/ISOCurrencies.php#L90-L102
	 * @return array
	 *
	 * @throws \RuntimeException Throws runtime exception if currencies could not be loaded from file.
	 */
	private static function load_currencies() {
		$file = __DIR__ . '/../resources/currencies.php';

		if ( is_readable( $file ) ) {
			$currencies = array();

			/**
			 * Data.
			 *
			 * @psalm-suppress UnresolvableInclude
			 *
			 * @var array
			 */
			$data = require $file;

			foreach ( $data as $info ) {
				$currency = new Currency();

				$currency->set_alphabetic_code( $info['alphabetic_code'] );
				$currency->set_numeric_code( $info['numeric_code'] );
				$currency->set_name( $info['name'] );
				$currency->set_symbol( $info['symbol'] );
				$currency->set_number_decimals( $info['number_decimals'] );

				$currencies[ $currency->get_alphabetic_code() ] = $currency;
			}

			return $currencies;
		}

		throw new \RuntimeException( 'Failed to load currencies.' );
	}
}
