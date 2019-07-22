<?php
/**
 * Currency
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2019 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

/**
 * Currency
 *
 * @author  Remco Tolsma
 * @version 1.2.2
 * @since   1.0.0
 */
class Currency {
	/**
	 * Alphabetic code.
	 *
	 * @var string|null
	 */
	private $alphabetic_code;

	/**
	 * Numeric code.
	 *
	 * @var string|null
	 */
	private $numeric_code;

	/**
	 * Symbol.
	 *
	 * @var string|null
	 */
	private $symbol;

	/**
	 * Name.
	 *
	 * @var string|null
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
	 * @return string|null
	 */
	public function get_alphabetic_code() {
		return $this->alphabetic_code;
	}

	/**
	 * Set alphabetic code.
	 *
	 * @param string|null $alphabetic_code Alphabetic code.
	 * @return void
	 */
	public function set_alphabetic_code( $alphabetic_code ) {
		$this->alphabetic_code = $alphabetic_code;
	}

	/**
	 * Get numeric code.
	 *
	 * @return string|null
	 */
	public function get_numeric_code() {
		return $this->numeric_code;
	}

	/**
	 * Set numeric code.
	 *
	 * @param string|null $numeric_code Numeric code.
	 * @return void
	 */
	public function set_numeric_code( $numeric_code ) {
		$this->numeric_code = $numeric_code;
	}

	/**
	 * Get symbol.
	 *
	 * @return string|null
	 */
	public function get_symbol() {
		return $this->symbol;
	}

	/**
	 * Set symbol.
	 *
	 * @param string|null $symbol Symbol.
	 * @return void
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
	 * @return void
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
	 * @return string|null
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Set name.
	 *
	 * @param string|null $name Currency name.
	 * @return void
	 */
	public function set_name( $name ) {
		$this->name = $name;
	}
}
