<?php
/**
 * BC Math Calculator
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money\Calculator;

use Pronamic\WordPress\Money\Calculator;

/**
 * BC Math Calculator
 *
 * @author  Remco Tolsma
 * @version 1.2.5
 * @since   1.2.2
 */
class BcMathCalculator implements Calculator {
	/**
	 * Scale.
	 *
	 * @var int
	 */
	private $scale;

	/**
	 * Construct BC Math Calculator.
	 *
	 * @param int $scale Scale.
	 */
	public function __construct( $scale = 14 ) {
		$this->scale = $scale;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function supported() {
		return extension_loaded( 'bcmath' );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/BcMathCalculator.php
	 *
	 * @param string $value  Value.
	 * @param string $addend Addend.
	 *
	 * @return string
	 */
	public function add( $value, $addend ) {
		if ( ! \is_numeric( $value ) || ! \is_numeric( $addend ) ) {
			return $value;
		}

		return bcadd( $value, $addend, $this->scale );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/BcMathCalculator.php#L51-L62
	 *
	 * @param string $value      Value.
	 * @param string $subtrahend Subtrahend.
	 *
	 * @return string
	 */
	public function subtract( $value, $subtrahend ) {
		if ( ! \is_numeric( $value ) || ! \is_numeric( $subtrahend ) ) {
			return $value;
		}

		return bcsub( $value, $subtrahend, $this->scale );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/BcMathCalculator.php#L64-L72
	 *
	 * @param string           $value      Value.
	 * @param int|float|string $multiplier Multiplier.
	 *
	 * @return string
	 */
	public function multiply( $value, $multiplier ) {
		$multiplier = strval( $multiplier );

		if ( ! \is_numeric( $value ) || ! \is_numeric( $multiplier ) ) {
			return $value;
		}

		return bcmul( $value, $multiplier, $this->scale );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/BcMathCalculator.php#L74-L82
	 * @link https://php.net/bcdiv
	 *
	 * @param string           $value   Value.
	 * @param int|float|string $divisor Divisor.
	 *
	 * @return string|null
	 */
	public function divide( $value, $divisor ) {
		$divisor = strval( $divisor );

		if ( ! \is_numeric( $value ) || ! \is_numeric( $divisor ) ) {
			return $value;
		}

		return bcdiv( $value, $divisor, $this->scale );
	}
}
