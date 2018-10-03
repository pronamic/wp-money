<?php
/**
 * Money
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2018 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

/**
 * Money
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class Money {
	/**
	 * Amount.
	 *
	 * @var float
	 */
	private $amount;

	/**
	 * Currency.
	 *
	 * @var Currency
	 */
	private $currency;

	/**
	 * Construct and initialize money object.
	 *
	 * @param string|int|float     $amount   Amount.
	 * @param Currency|string|null $currency Currency.
	 */
	public function __construct( $amount = 0, $currency = null ) {
		$this->set_amount( $amount );
		$this->set_currency( $currency );
	}

	/**
	 * Get default format.
	 *
	 * @return string
	 */
	public static function get_default_format() {
		/* translators: 1: currency symbol, 2: amount, 3: currency code, note: use non-breaking space! */
		$format = _x( '%1$s%2$s %3$s', 'money format', 'pronamic-money' );
		// Note:               ↳ Non-breaking space

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
				number_format_i18n( $this->amount, $this->currency->get_number_decimals() ),
				$this->currency->get_alphabetic_code()
			);
		}

		return number_format_i18n( $this->amount, 2 );
	}

	/**
	 * Get amount.
	 *
	 * @return float float amount.
	 */
	public function get_amount() {
		return $this->amount;
	}

	/**
	 * Get cents.
	 *
	 * @return float 
	 */
	public function get_cents() {
		return $this->amount * 100;
	}

	/**
	 * Set amount.
	 *
	 * @param mixed $amount Amount.
	 */
	public function set_amount( $amount ) {
		$this->amount = floatval( $amount );
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
