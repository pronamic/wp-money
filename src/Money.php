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
 * @version 1.0
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
	 * @var float                $amount
	 * @var Currency|string|null $currency
	 */
	public function __construct( $amount = 0, $currency = null ) {
		$this->set_amount( $amount );
		$this->set_currency( $currency );
	}

	public static function get_default_format() {
		/* translators: 1: currency symbol, 2: amount, 3: currency code */
		$format = _x( '%1$s%2$s %3$s', 'money format', 'pronamic-money' );

		$format = apply_filters( 'pronamic_money_default_format', $format );

		return $format;
	}

	/**
	 * Format i18n.
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
	 * Set amount.
	 *
	 * @param float $amount Amount.
	 */
	public function set_amount( $amount ) {
		$this->amount = $amount;
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
		if ( is_string( $currency ) ) {
			$currency = Currency::get_instance( $currency );
		}

		$this->currency = $currency;
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
