<?php
/**
 * Money
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

use JsonSerializable;
use Pronamic\WordPress\Number\Number;

/**
 * Money
 *
 * @author Remco Tolsma
 * @version 2.0.0
 * @since   1.0.0
 */
class Money implements JsonSerializable {
	/**
	 * Number.
	 *
	 * @var Number
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
	 * @param mixed           $value    Amount value.
	 * @param Currency|string $currency Currency.
	 */
	public function __construct( $value = 0, $currency = 'EUR' ) {
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

		/**
		 * Filters the default money format.
		 *
		 * Default format: `%1$s%2$s %3$s`
		 *
		 * - 1: Currency symbol
		 * - 2: Amount value
		 * - 3: Currency code
		 *
		 * Note: use non-breaking space ` ` in money formatting.
		 *
		 * @param string $format Format.
		 */
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

		$alphabetic_code = $this->currency->get_alphabetic_code();
		$number_decimals = $this->currency->get_number_decimals();

		// Handle non trailing zero formatter.
		if ( false !== \strpos( $format, '%2$NTZ' ) ) {
			$decimals = \substr( $this->format(), ( - 1 * $number_decimals ), $number_decimals );

			if ( 0 === (int) $decimals ) {
				$number_decimals = 0;
			}

			$format = \str_replace( '%2$NTZ', '%2$s', $format );
		}

		return \sprintf(
			$format,
			(string) $this->currency->get_symbol(),
			$this->amount->format_i18n( $number_decimals ),
			\strval( $alphabetic_code )
		);
	}

	/**
	 * Format i18n without trailing zeros.
	 *
	 * @param string|null $format Format.
	 *
	 * @return string
	 */
	public function format_i18n_non_trailing_zeros( $format = null ) {
		if ( is_null( $format ) ) {
			$format = self::get_default_format();
		}

		$format = str_replace( '%2$s', '%2$NTZ', $format );

		return $this->format_i18n( $format );
	}

	/**
	 * Format.
	 *
	 * @param string|null $format Format.
	 *
	 * @return string
	 */
	public function format( $format = null ) {
		if ( is_null( $format ) ) {
			$format = '%2$s';
		}

		$alphabetic_code = $this->currency->get_alphabetic_code();

		return \sprintf(
			$format,
			(string) $this->currency->get_symbol(),
			$this->amount->format( $this->get_currency()->get_number_decimals() ),
			\strval( $alphabetic_code )
		);
	}

	/**
	 * Number format.
	 *
	 * @param int         $decimals            Precision of the number of decimal places.
	 * @param string|null $decimal_separator   Sets the separator for the decimal point.
	 * @param string|null $thousands_separator Sets the thousands separator.
	 * @return string
	 */
	public function number_format( $decimals = null, $decimal_separator = '.', $thousands_separator = ',' ) {
		if ( null === $decimals ) {
			$decimals = $this->currency->get_number_decimals();
		}

		return $this->amount->format( $decimals, $decimal_separator, $thousands_separator );
	}

	/**
	 * Number format i18n.
	 *
	 * @param int $decimals Precision of the number of decimal places.
	 * @return string
	 */
	public function number_format_i18n( $decimals = null ) {
		if ( null === $decimals ) {
			$decimals = $this->currency->get_number_decimals();
		}

		return $this->amount->format_i18n( $decimals );
	}

	/**
	 * Get value.
	 *
	 * @return string Amount value.
	 */
	public function get_value() {
		return $this->amount->get_value();
	}

	/**
	 * Get number.
	 *
	 * @return Number
	 */
	public function get_number() {
		return $this->amount;
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
	 * @link https://en.wikipedia.org/wiki/Cent_(currency)
	 * @link https://simple.wikipedia.org/wiki/ISO_4217
	 * @since 1.2.1
	 * @return Number
	 */
	public function get_minor_units() {
		return $this->amount->multiply( Number::from_mixed( \pow( 10, $this->currency->get_number_decimals() ) ) );
	}

	/**
	 * Set value.
	 *
	 * @param mixed $value Amount value.
	 * @return void
	 */
	final public function set_value( $value ) {
		$this->amount = Number::from_mixed( $value );
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
	 * @param string|Currency $currency Currency.
	 * @return void
	 */
	final public function set_currency( $currency ) {
		if ( ! $currency instanceof Currency ) {
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
		return \sprintf(
			'%s %s',
			$this->currency->get_alphabetic_code(),
			$this->amount->format( $this->get_currency()->get_number_decimals() )
		);
	}

	/**
	 * JSON serialize.
	 *
	 * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return object
	 */
	public function jsonSerialize(): object {
		return (object) [
			'value'    => $this->amount->get_value(),
			'currency' => $this->currency->jsonSerialize(),
		];
	}

	/**
	 * Returns a new Money object that represents
	 * the sum of this and an other Money object.
	 *
	 * @param Money $addend Addend.
	 * @return Money
	 */
	public function add( Money $addend ) {
		$result = $this->amount->add( $addend->get_number() );

		return new self( $result, $this->currency );
	}

	/**
	 * Returns a new Money object that represents
	 * the difference of this and an other Money object.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Money.php#L235-L255
	 * @param Money $subtrahend Subtrahend.
	 * @return Money
	 */
	public function subtract( Money $subtrahend ) {
		$result = $this->amount->subtract( $subtrahend->get_number() );

		return new self( $result, $this->currency );
	}

	/**
	 * Returns a new Money object that represents
	 * the multiplied value of this Money object.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Money.php#L299-L316
	 * @param mixed $multiplier Multiplier.
	 * @return Money
	 */
	public function multiply( $multiplier ) {
		$multiplier = Number::from_mixed( $multiplier );

		$result = $this->amount->multiply( $multiplier );

		return new self( $result, $this->currency );
	}

	/**
	 * Returns a new Money object that represents
	 * the divided value of this Money object.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Money.php#L318-L341
	 * @param mixed $divisor Divisor.
	 * @return Money
	 */
	public function divide( $divisor ) {
		$divisor = Number::from_mixed( $divisor );

		$result = $this->amount->divide( $divisor );

		return new self( $result, $this->currency );
	}

	/**
	 * Absolute.
	 *
	 * @link https://github.com/moneyphp/money/blob/v4.0.1/src/Money.php#L411-L417
	 * @return Money
	 */
	public function absolute() {
		return new self(
			$this->amount->absolute(),
			$this->currency
		);
	}

	/**
	 * Negative.
	 *
	 * @link https://github.com/pronamic/wp-money/issues/5
	 * @return Money
	 */
	public function negative() {
		return new self(
			$this->amount->negative(),
			$this->currency
		);
	}

	/**
	 * Checks if the value represented by this object is zero.
	 *
	 * @link https://github.com/moneyphp/money/blob/v4.0.1/src/Money.php#L425-L431
	 * @link https://github.com/pronamic/wp-money/issues/7
	 * @return bool True if zero, false otherwise.
	 */
	public function is_zero() {
		return $this->amount->is_zero();
	}
}
