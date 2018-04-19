<?php
/**
 * Currency
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2018 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

/**
 * Currency
 *
 * @author Remco Tolsma
 * @version 1.0
 */
class Currency {
	/**
	 * Alphabetic code.
	 *
	 * @var string
	 */
	private $alphabetic_code;

	/**
	 * Numeric code.
	 *
	 * @var string
	 */
	private $numeric_code;

	/**
	 * Symbol.
	 *
	 * @var string
	 */
	private $symbol;

	/**
	 * Name.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Number decimals.
	 *
	 * @var int
	 */
	private $number_decimals;

	/**
	 * Construct and initialize currency object.
	 *
	 * @param string $alphabetic_code
	 * @param string $numeric_code
	 * @param string $name
	 * @param string $symbol
	 * @param int    $number_decimals
	 */
	public function __construct( $alphabetic_code, $numeric_code, $name, $symbol, $number_decimals = 2 ) {
		$this->alphabetic_code = $alphabetic_code;
		$this->numeric_code    = $numeric_code;
		$this->name            = $name;
		$this->symbol          = $symbol;
		$this->number_decimals = $number_decimals;
	}

	public function get_alphabetic_code() {
		return $this->alphabetic_code;
	}

	public function get_symbol() {
		return $this->symbol;
	}

	public function get_number_decimals() {
		return $this->number_decimals;
	}

	public function get_numeric_code() {
		return $this->numeric_code;
	}

	public static function get_instance( $alphabetic_code ) {
		$currencies = Currencies::get_currencies();

		if ( array_key_exists( $alphabetic_code, $currencies ) ) {
			return $currencies[ $alphabetic_code ];
		}
	}
}
