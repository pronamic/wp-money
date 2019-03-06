<?php
/**
 * Money
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2019 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

/**
 * Money
 *
 * @author Remco Tolsma
 * @version 1.2.0
 * @since   1.0.0
 */
class Money {
	/**
	 * Amount value.
	 *
	 * @var float
	 */
	private $value;

	/**
	 * Currency.
	 *
	 * @var Currency
	 */
	private $currency;

	/**
	 * Construct and initialize money object.
	 *
	 * @param string|int|float     $value    Amount value.
	 * @param Currency|string|null $currency Currency.
	 */
	public function __construct( $value = 0, $currency = null ) {
		$this->set_value( $value );
		$this->set_currency( $currency );
	}

	/**
	 * Get default format.
	 *
	 * @return string
	 */
	public static function get_default_format() {
		/* translators: 1: currency symbol, 2: amount value, 3: currency code, note: use non-breaking space! */
		$format = _x( '%1$s%2$s %3$s', 'money format', 'pronamic-money' );
		// Note:               ↳ Non-breaking space.
		$format = apply_filters( 'pronamic_money_default_format', $format );

		return $format;
	}

	/**
	 * Format i18n.
	 *
	 * @param string|null $format Format.
	 *
	 * @return string
	 */
	public function format_i18n( $format = null ) {
		if ( is_null( $format ) ) {
			$format = self::get_default_format();
		}

		if ( isset( $this->currency ) ) {
			return sprintf(
				$format,
				$this->currency->get_symbol(),
				number_format_i18n( $this->get_value(), $this->currency->get_number_decimals() ),
				$this->currency->get_alphabetic_code()
			);
		}

		return number_format_i18n( $this->get_value(), 2 );
	}

	/**
	 * Get value.
	 *
	 * @return float Amount value.
	 */
	public function get_value() {
		return $this->value;
	}

	/**
	 * Get amount.
	 *
	 * @deprecated 1.2.0
	 * @return float Amount value.
	 */
	public function get_amount() {
		_deprecated_function( __METHOD__, '1.2.0', 'Money::get_value()' );

		return $this->get_value();
	}

	/**
	 * Get cents.
	 *
	 * @return float
	 */
	public function get_cents() {
		return $this->value * 100;
	}

	/**
	 * Get amount in minor units.
	 *
	 * Examples for value 10:
	 *   JPY 0 decimals: 10
	 *   EUR 2 decimals: 1000
	 *   BHD 3 decimals: 10000
	 *   NLG 4 decimals: 100000
	 *
	 * @return int
	 */
	public function get_minor_units() {
		// Use 2 decimals by default (most common).
		$decimals = 2;

		// Get number of decimals from currency if available.
		if ( $this->get_currency() ) {
			$decimals = $this->currency->get_number_decimals();
		}

		// Return amount in minor units.
		if ( function_exists( 'bcmul' ) ) {
			$minor_units = bcmul( $this->value, pow( 10, $decimals ), 0 );
		} else {
			$minor_units = $this->value * pow( 10, $decimals );
		}

		return (int) $minor_units;
	}

	/**
	 * Set value.
	 *
	 * @param mixed $value Amount value.
	 */
	public function set_value( $value ) {
		$this->value = floatval( $value );
	}

	/**
	 * Set amount.
	 *
	 * @deprecated 1.2.0
	 * @param mixed $value Amount value.
	 */
	public function set_amount( $value ) {
		_deprecated_function( __METHOD__, '1.2.0', 'Money::set_value()' );

		$this->set_value( $value );
	}

	/**
	 * Get currency.
	 *
	 * @return Currency
	 */
	public function get_currency() {
		return $this->currency;
	}

	/**
	 * Set currency.
	 *
	 * @param string $currency Currency.
	 */
	public function set_currency( $currency ) {
		if ( is_object( $currency ) && is_a( $currency, __NAMESPACE__ . '\Currency' ) ) {
			$this->currency = $currency;

			return;
		}

		$this->currency = Currency::get_instance( $currency );
	}

	/**
	 * Create a string representation of this money object.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->format_i18n();
	}
}
