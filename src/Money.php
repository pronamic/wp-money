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

use Pronamic\WordPress\Money\Calculator\BcMathCalculator;
use Pronamic\WordPress\Money\Calculator\PhpCalculator;

/**
 * Money
 *
 * @author Remco Tolsma
 * @version 1.2.2
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
	 * Calculator.
	 *
	 * @var Calculator|null
	 */
	private static $calculator;

	/**
	 * Calculators.
	 *
	 * @var array
	 */
	private static $calculators = array(
		BcMathCalculator::class,
		PhpCalculator::class,
	);

	/**
	 * Construct and initialize money object.
	 *
	 * @param string|int|float $value    Amount value.
	 * @param Currency|string  $currency Currency.
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

		if ( ! empty( $alphabetic_code ) ) {
			$number_decimals = $this->currency->get_number_decimals();

			// Handle non trailing zero formatter.
			if ( false !== strpos( $format, '%2$NTZ' ) ) {
				$decimals = substr( $this->format(), ( - 1 * $number_decimals ), $number_decimals );

				if ( 0 === (int) $decimals ) {
					$number_decimals = 0;
				}

				$format = str_replace( '%2$NTZ', '%2$s', $format );
			}

			return sprintf(
				$format,
				strval( $this->currency->get_symbol() ),
				number_format_i18n( $this->get_value(), $number_decimals ),
				strval( $this->currency->get_alphabetic_code() )
			);
		}

		return number_format_i18n( $this->get_value(), 2 );
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

		if ( ! empty( $alphabetic_code ) ) {
			return sprintf(
				$format,
				strvaL( $this->currency->get_symbol() ),
				number_format( $this->get_value(), $this->get_currency()->get_number_decimals(), '.', '' ),
				strval( $this->currency->get_alphabetic_code() )
			);
		}

		return number_format( $this->get_value(), 2, '.', '' );
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
	 *
	 * @deprecated 1.2.2 Use `Money::get_minor_units()` instead.
	 */
	public function get_cents() {
		return (float) $this->get_minor_units();
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
	 * @since 1.2.1
	 *
	 * @return int
	 */
	public function get_minor_units() {
		$calculator = $this->get_calculator();

		$minor_units = $calculator->multiply( strval( $this->get_value() ), pow( 10, $this->currency->get_number_decimals() ) );

		return (int) $minor_units;
	}

	/**
	 * Set value.
	 *
	 * @param mixed $value Amount value.
	 * @return void
	 */
	public function set_value( $value ) {
		$this->value = floatval( $value );
	}

	/**
	 * Set amount.
	 *
	 * @deprecated 1.2.0
	 * @param mixed $value Amount value.
	 * @return void
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
	 * @param string|Currency $currency Currency.
	 * @return void
	 */
	public function set_currency( $currency ) {
		if ( $currency instanceof Currency ) {
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

	/**
	 * Returns a new Money object that represents
	 * the sum of this and an other Money object.
	 *
	 * @param Money $addend Addend.
	 *
	 * @return Money
	 */
	public function add( Money $addend ) {
		$value = $this->get_value();

		$calculator = $this->get_calculator();

		$value = $calculator->add( strval( $value ), strval( $addend->get_value() ) );

		return new self( $value, $this->get_currency() );
	}

	/**
	 * Returns a new Money object that represents
	 * the difference of this and an other Money object.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Money.php#L235-L255
	 *
	 * @param Money $subtrahend Subtrahend.
	 *
	 * @return Money
	 */
	public function subtract( Money $subtrahend ) {
		$value = $this->get_value();

		$calculator = $this->get_calculator();

		$value = $calculator->subtract( strval( $value ), strval( $subtrahend->get_value() ) );

		return new self( $value, $this->get_currency() );
	}

	/**
	 * Returns a new Money object that represents
	 * the multiplied value of this Money object.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Money.php#L299-L316
	 *
	 * @param int|float|string $multiplier Multiplier.
	 *
	 * @return Money
	 */
	public function multiply( $multiplier ) {
		$value = $this->get_value();

		$calculator = $this->get_calculator();

		$value = $calculator->multiply( strval( $value ), $multiplier );

		return new self( $value, $this->get_currency() );
	}

	/**
	 * Returns a new Money object that represents
	 * the divided value of this Money object.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Money.php#L318-L341
	 *
	 * @param int|float|string $divisor Divisor.
	 *
	 * @return Money
	 */
	public function divide( $divisor ) {
		$value = $this->get_value();

		$calculator = $this->get_calculator();

		$value = $calculator->divide( strval( $value ), $divisor );

		if ( null === $value ) {
			$value = $this->get_value();
		}

		return new self( $value, $this->get_currency() );
	}

	/**
	 * Initialize calculator.
	 *
	 * @return Calculator
	 *
	 * @throws \RuntimeException If cannot find calculator for money calculations.
	 */
	private static function initialize_calculator() {
		$calculator_classes = self::$calculators;

		foreach ( $calculator_classes as $calculator_class ) {
			if ( $calculator_class::supported() ) {
				$calculator = new $calculator_class();

				if ( $calculator instanceof Calculator ) {
					return $calculator;
				}
			}
		}

		throw new \RuntimeException( 'Cannot find calculator for money calculations' );
	}

	/**
	 * Get calculator.
	 *
	 * @return Calculator
	 */
	protected function get_calculator() {
		if ( null === self::$calculator ) {
			self::$calculator = self::initialize_calculator();
		}

		return self::$calculator;
	}
}
