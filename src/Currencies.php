<?php
/**
 * Currencies
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
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
	 * @var array<string, Currency>|null
	 */
	private static $currencies;

	/**
	 * Get currencies.
	 *
	 * @return array<string, Currency>
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
		$currency = new Currency( $alphabetic_code );

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
	 * @return array<string, Currency>
	 * @throws \RuntimeException Throws runtime exception if currencies could not be loaded from file.
	 * @throws \Exception Throws exception if alphabetic code does not exists.
	 */
	private static function load_currencies() {
		$file = __DIR__ . '/../resources/currencies.php';

		if ( ! is_readable( $file ) ) {
			throw new \RuntimeException( 'Failed to load currencies.' );
		}

		$currencies = array();

		/**
		 * Data.
		 *
		 * @psalm-suppress UnresolvableInclude
		 *
		 * @var array<int, array<string, mixed>>
		 */
		$data = require $file;

		foreach ( $data as $info ) {
			if ( ! \array_key_exists( 'alphabetic_code', $info ) ) {
				throw new \Exception( 'Alphabetic code is required.' );
			}

			$alphabetic_code = \strval( $info['alphabetic_code'] );

			$currency = new Currency( $alphabetic_code );

			$currency->set_numeric_code( $info['numeric_code'] );
			$currency->set_name( $info['name'] );
			$currency->set_symbol( $info['symbol'] );
			$currency->set_number_decimals( $info['number_decimals'] );

			$currencies[ $alphabetic_code ] = $currency;
		}

		return $currencies;
	}
}
