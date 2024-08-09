<?php
/**
 * Parser
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

use Exception;

/**
 * Parser
 *
 * @author  Remco Tolsma
 * @version 2.0.0
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

		// Separators.
		$separators = [ $decimal_sep, '.', ',' ];
		$separators = array_unique( array_filter( $separators ) );

		// Check.
		foreach ( [ - 3, - 2 ] as $i ) {
			$test = substr( $string, $i, 1 );

			if ( in_array( $test, $separators, true ) ) {
				$decimal_sep = $test;

				break;
			}
		}

		// Split.
		$position = false;

		if ( is_string( $decimal_sep ) ) {
			$position = strrpos( $string, $decimal_sep );
		}

		// Check decimal position on -4th position at end of string of negative amount (e.g. `2.500,75-`).
		if ( false === $position && '-' === \substr( $string, -1, 1 ) ) {
			$test = substr( $string, -4, 1 );

			if ( is_string( $test ) && in_array( $test, $separators, true ) ) {
				$position = strrpos( $string, $test );
			}
		}

		if ( false !== $position ) {
			$full = substr( $string, 0, $position );
			$half = substr( $string, $position + 1 );

			/*
			 * Consider `-` after decimal separator as alternative notation for 'no minor units' (e.g. `€ 5,-`).
			 *
			 * @link https://taaladvies.net/taal/advies/vraag/275/euro_komma_en_streepje_in_de_notatie_van_hele_bedragen/
			 */
			if ( \in_array( $half, [ '-', '–', '—' ], true ) ) {
				$half = '';
			}

			$end_minus = ( '-' === \substr( $half, -1, 1 ) );

			$full = filter_var( $full, FILTER_SANITIZE_NUMBER_INT );
			$half = filter_var( $half, FILTER_SANITIZE_NUMBER_INT );

			// Make amount negative if half string ends with minus sign.
			if ( $end_minus ) {
				// Make full negative.
				$full = sprintf( '-%s', $full );

				// Remove minus from end of half.
				$half = \substr( (string) $half, 0, -1 );
			}

			$string = $full . '.' . $half;
		} else {
			// Make amount negative if full string ends with minus sign.
			if ( '-' === \substr( $string, -1, 1 ) ) {
				$string = sprintf( '-%s', \substr( $string, 0, -1 ) );
			}

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
