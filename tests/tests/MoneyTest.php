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

use WP_UnitTestCase;

/**
 * Money
 *
 * @author Remco Tolsma
 * @version 1.0
 */
class MoneyTest extends WP_UnitTestCase {
	/**
	 * Test default format.
	 *
	 * @see https://github.com/WordPress/WordPress/blob/4.9.5/wp-includes/l10n.php
	 *
	 * @dataProvider default_format_provider
	 */
	public function test_default_format( $locale, $expected ) {
		// Note: Switching from nl_NL to fr_FR back to nl_NL is not working correctly (bug?).
		switch_to_locale( $locale );

		$value = Money::get_default_format();

		$this->assertEquals( $locale, get_locale() );
		$this->assertEquals( $expected, $value );
	}

	public function default_format_provider() {
		// Note: Switching from nl_NL to fr_FR back to nl_NL is not working correctly (bug?).
		return array(
			array( 'en_US', '%1$s%2$s %3$s' ),
			array( 'fr_FR', '%1$s%2$s %3$s' ),
			array( 'nl_NL', '%1$s %2$s' ),
		);
	}

	/**
	 * Test format.
	 *
	 * @see https://github.com/WordPress/WordPress/blob/4.9.5/wp-includes/l10n.php
	 *
	 * @param float $amount
	 * @param string $currency
	 * @param string $locale
	 * @param string $expected
	 *
	 * @dataProvider format_provider
	 */
	public function test_format( $locale, $currency, $amount, $expected ) {
		// Note: Switching from nl_NL to fr_FR back to nl_NL is not working correctly (bug?).
		switch_to_locale( $locale );

		$money = new Money( $amount, $currency );

		$value = $money->format_i18n();

		// Expect space instead of non-breaking space with PHP < 5.4.
		// @link https://core.trac.wordpress.org/ticket/10373
		if ( version_compare( PHP_VERSION, '5.4', '<' ) ) {
			// PHP < 5.4.0 does not support multiple bytes in thousands separator.
			$nbsp = ' ';

			$expected = str_replace( $nbsp, chr( ord( $nbsp ) ), $expected );
		}

		$this->assertEquals( $locale, get_locale() );
		$this->assertEquals( $expected, $value, 'Locale: ' . get_locale() . ' Money format: ' . Money::get_default_format() . ' Test: ' . _x( '%1$s%2$s %3$s', 'money format', 'pronamic-money' ) );
	}

	public static function fix_expected_php53( $value ) {
		// PHP < 5.4.0 does not support multiple bytes in thousands separator.
		if ( version_compare( PHP_VERSION, '5.4', '<' ) ) {
			$nbsp = ' ';

			$replace = chr( ord( $nbsp ) );

			$value = str_replace( $nbsp, $replace, $value );
		}

		return $value;
	}

	public function format_provider() {


		// Note: Switching from nl_NL to fr_FR back to nl_NL is not working correctly (bug?).
		return array(
			// Dutch
			array( 'nl_NL', 'EUR', 49.7512, '€ 49,75' ),
			array( 'nl_NL', 'NLG', 49.7512, 'G 49,7512' ),
			array( 'nl_NL', 'USD', 49.7512, '$ 49,75' ),
			array( 'nl_NL', 'USD', 1234567890.1234, '$ 1.234.567.890,12' ),
			// English
			array( 'en_US', 'EUR', 49.7512, '€49.75 EUR' ),
			array( 'en_US', 'USD', 1234567890.1234, '$1,234,567,890.12 USD' ),
			// French
			array( 'fr_FR', 'USD', 1234567890.1234, '$' . self::fix_expected_php53( '1 234 567 890,12' ) . ' USD' ),
		);
	}
}
