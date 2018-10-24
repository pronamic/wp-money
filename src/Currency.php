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
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
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
	 */
	public function __construct() {
		$this->set_number_decimals( 2 );
	}

	/**
	 * Get alphabetic code.
	 *
	 * @return null|string
	 */
	public function get_alphabetic_code() {
		return $this->alphabetic_code;
	}

	/**
	 * Set alphabetic code.
	 *
	 * @param string $alphabetic_code Alphabetic code.
	 */
	public function set_alphabetic_code( $alphabetic_code ) {
		$this->alphabetic_code = $alphabetic_code;
	}

	/**
	 * Get numeric code.
	 *
	 * @return null|string
	 */
	public function get_numeric_code() {
		return $this->numeric_code;
	}

	/**
	 * Set numeric code.
	 *
	 * @param string $numeric_code Numeric code.
	 */
	public function set_numeric_code( $numeric_code ) {
		$this->numeric_code = $numeric_code;
	}

	/**
	 * Get symbol.
	 *
	 * @return null|string
	 */
	public function get_symbol() {
		return $this->symbol;
	}

	/**
	 * Set symbol.
	 *
	 * @param string $symbol Symbol.
	 */
	public function set_symbol( $symbol ) {
		$this->symbol = $symbol;
	}

	/**
	 * Get number decimals.
	 *
	 * @return int
	 */
	public function get_number_decimals() {
		return $this->number_decimals;
	}

	/**
	 * Set number decimals.
	 *
	 * @param int $number_decimals Number of decimals.
	 */
	public function set_number_decimals( $number_decimals ) {
		$this->number_decimals = intval( $number_decimals );
	}

	/**
	 * Get instance.
	 *
	 * @param string $alphabetic_code Alphabetic code.
	 *
	 * @return Currency
	 */
	public static function get_instance( $alphabetic_code ) {
		return Currencies::get_currency( $alphabetic_code );
	}

	/**
	 * Get name.
	 *
	 * @return null|string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Set name.
	 *
	 * @param string $name Currency name.
	 */
	public function set_name( $name ) {
		$this->name = $name;
	}
}
