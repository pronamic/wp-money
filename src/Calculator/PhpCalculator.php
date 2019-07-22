<?php
/**
 * PHP Calculator
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2019 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money\Calculator;

use Pronamic\WordPress\Money\Calculator;

/**
 * GMP Calculator
 *
 * @author  Remco Tolsma
 * @version 1.2.2
 * @since   1.2.2
 */
class PhpCalculator implements Calculator {
	/**
	 * {@inheritdoc}
	 */
	public static function supported() {
		return true;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/PhpCalculator.php#L30-L40
	 *
	 * @param string $value  Value.
	 * @param string $addend Addend.
	 *
	 * @return string
	 */
	public function add( $value, $addend ) {
		$result = floatval( $value ) + floatval( $addend );

		return strval( $result );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/PhpCalculator.php#L42-L52
	 *
	 * @param string $value      Value.
	 * @param string $subtrahend Subtrahend.
	 *
	 * @return string
	 */
	public function subtract( $value, $subtrahend ) {
		$result = floatval( $value ) - floatval( $subtrahend );

		return strval( $result );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/PhpCalculator.php#L54-L64
	 *
	 * @param string           $value      Value.
	 * @param int|float|string $multiplier Multiplier.
	 *
	 * @return string
	 */
	public function multiply( $value, $multiplier ) {
		$result = floatval( $value ) * floatval( $multiplier );

		return strval( $result );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/PhpCalculator.php#L66-L76
	 *
	 * @param string           $value   Value.
	 * @param int|float|string $divisor Divisor.
	 *
	 * @return string|null
	 */
	public function divide( $value, $divisor ) {
		$result = floatval( $value ) / floatval( $divisor );

		return strval( $result );
	}
}
