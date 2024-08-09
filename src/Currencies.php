<?php
/**
 * Currencies
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
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
 * @version 2.0.0
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
		$currencies = self::get_currencies();

		if ( \array_key_exists( $alphabetic_code, $currencies ) ) {
			return $currencies[ $alphabetic_code ];
		}

		return new Currency( $alphabetic_code );
	}

	/**
	 * Load currencies.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.1.3/src/Currencies/ISOCurrencies.php#L90-L102
	 * @return array<string, Currency>
	 * @throws \RuntimeException Throws runtime exception if currencies could not be loaded from file.
	 */
	private static function load_currencies() {
		$file = __DIR__ . '/../resources/currencies.php';

		$currencies = [];

		/**
		 * Data.
		 *
		 * @psalm-suppress UnresolvableInclude
		 *
		 * @var array<int, Currency>
		 */
		$data = require $file;

		foreach ( $data as $currency ) {
			$alphabetic_code = $currency->get_alphabetic_code();

			$currencies[ $alphabetic_code ] = $currency;
		}

		return $currencies;
	}
}
