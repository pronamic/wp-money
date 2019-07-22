<?php
/**
 * Calculator
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2019 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

/**
 * Calculator
 *
 * @author  Remco Tolsma
 * @version 1.2.2
 * @since   1.2.2
 */
interface Calculator {
	/**
	 * Returns whether the calculator is supported in
	 * the current server environment.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator.php#L12-L18
	 *
	 * @return bool
	 */
	public static function supported();

	/**
	 * Add added to amount.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator.php#L30-L38
	 *
	 * @param string $value  Value.
	 * @param string $addend Addend.
	 *
	 * @return string
	 */
	public function add( $value, $addend );

	/**
	 * Subtract subtrahend from amount.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator.php#L40-L48
	 *
	 * @param string $value      Value.
	 * @param string $subtrahend Subtrahend.
	 *
	 * @return string
	 */
	public function subtract( $value, $subtrahend );

	/**
	 * Multiply amount with multiplier.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator.php#L50-L58
	 *
	 * @param string           $value      Value.
	 * @param int|float|string $multiplier Multiplier.
	 *
	 * @return string
	 */
	public function multiply( $value, $multiplier );

	/**
	 * Divide amount with divisor.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator.php#L60-L68
	 *
	 * @param string           $value   Value.
	 * @param int|float|string $divisor Divisor.
	 *
	 * @return string|null
	 */
	public function divide( $value, $divisor );
}
