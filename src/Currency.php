<?php
/**
 * Currency
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

use JsonSerializable;

/**
 * Currency
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 * @since   1.0.0
 */
class Currency implements JsonSerializable {
	/**
	 * Alphabetic code.
	 *
	 * @var string
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
	 *
	 * @param string      $alphabetic_code Alphabetic currency code.
	 * @param string|null $numeric_code    Numeric code.
	 * @param string|null $name            Name.
	 * @param string|null $symbol          Symbol.
	 * @param int         $number_decimals Number decimals.
	 */
	public function __construct( $alphabetic_code, $numeric_code = null, $name = null, $symbol = null, $number_decimals = 2 ) {
		$this->set_alphabetic_code( $alphabetic_code );
		$this->set_numeric_code( $numeric_code );
		$this->set_name( $name );
		$this->set_symbol( $symbol );
		$this->set_number_decimals( $number_decimals );
	}

	/**
	 * Get alphabetic code.
	 *
	 * @return string
	 */
	public function get_alphabetic_code() {
		return $this->alphabetic_code;
	}

	/**
	 * Set alphabetic code.
	 *
	 * @param string $alphabetic_code Alphabetic code.
	 * @return void
	 * @throws \InvalidArgumentException Throws invalid argument exception if code is not 3 characters.
	 */
	final public function set_alphabetic_code( $alphabetic_code ) {
		if ( 3 !== \strlen( $alphabetic_code ) ) {
			throw new \InvalidArgumentException(
				\sprintf(
					'The alphabetical code of a currency must consist of 3 characters: %s.',
					\esc_html( $alphabetic_code )
				)
			);
		}

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
	final public function set_number_decimals( $number_decimals ) {
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

	/**
	 * JSON serialize.
	 *
	 * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return string
	 */
	public function jsonSerialize(): string {
		return $this->alphabetic_code;
	}
}
