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
 * @see https://github.com/moneyphp/money/blob/v3.1.3/resources/currency.php
 * 
 * @author Remco Tolsma
 * @version 1.0
 */
class Currencies {
	/**
	 * Map of known currencies indexed by code.
	 *
	 * @var array
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
	 * Load currencies.
	 *
	 * @see https://github.com/moneyphp/money/blob/v3.1.3/src/Currencies/ISOCurrencies.php#L90-L102
	 * @return array
	 */
	private static function load_currencies() {
		$file = __DIR__ . '/../resources/currencies.php';

		if ( is_readable( $file ) ) {
			$currencies = array();

			$data = require $file;

			foreach ( $data as $info ) {
				$currency = new Currency(
					$info['alphabetic_code'],
					$info['numeric_code'],
					$info['name'],
					$info['symbol'],
					$info['number_decimals']
				);

				$currencies[ $currency->get_alphabetic_code() ] = $currency;
			}

			return $currencies;
		}

		throw new \RuntimeException( 'Failed to load currencies.' );
	}
}
