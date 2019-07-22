<?php
/**
 * Parser
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2019 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

use Exception;

/**
 * Parser
 *
 * @author  Remco Tolsma
 * @version 1.2.2
 * @since   1.1.0
 */
class Parser {
	/**
	 * Parse.
	 *
	 * @link https://github.com/wp-pay/core/blob/2.0.2/src/Core/Util.php#L128-L176
	 *
	 * @param string $string String to parse as money.
	 *
	 * @return Money
	 *
	 * @throws Exception Throws exception when parsing string fails.
	 */
	public function parse( $string ) {
		global $wp_locale;

		$decimal_sep = $wp_locale->number_format['decimal_point'];

		// Seperators.
		$seperators = array( $decimal_sep, '.', ',' );
		$seperators = array_unique( array_filter( $seperators ) );

		// Check.
		foreach ( array( - 3, - 2 ) as $i ) {
			$test = substr( $string, $i, 1 );

			if ( in_array( $test, $seperators, true ) ) {
				$decimal_sep = $test;

				break;
			}
		}

		// Split.
		$position = false;

		if ( is_string( $decimal_sep ) ) {
			$position = strrpos( $string, $decimal_sep );
		}

		if ( false !== $position ) {
			$full = substr( $string, 0, $position );
			$half = substr( $string, $position + 1 );

			$full = filter_var( $full, FILTER_SANITIZE_NUMBER_INT );
			$half = filter_var( $half, FILTER_SANITIZE_NUMBER_INT );

			$string = $full . '.' . $half;
		} else {
			$string = filter_var( $string, FILTER_SANITIZE_NUMBER_INT );
		}

		// Filter.
		$value = filter_var( $string, FILTER_VALIDATE_FLOAT );

		if ( false === $value ) {
			throw new Exception( 'Could not parse value to money object.' );
		}

		return new Money( $value );
	}
}
