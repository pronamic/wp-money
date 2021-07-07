<?php
/**
 * Money
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

use WP_Locale;
use WP_UnitTestCase;

/**
 * Money
 *
 * @author Remco Tolsma
 * @version 1.2.2
 * @since   1.0.0
 */
class MoneyTest extends WP_UnitTestCase {
	/**
	 * Setup.
	 */
	public function setUp() {
		parent::setUp();

		if ( version_compare( PHP_VERSION, '5.4', '<' ) ) {
			add_filter( 'number_format_i18n', array( $this, 'maybe_fix_multibyte_number_format' ), 10, 3 );
		}
	}

	/**
	 * Maybe fix multibyte number format.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/4.9.6/wp-includes/functions.php#L206-L237
	 *
	 * @param string $formatted Formatted number.
	 * @param float  $number    The number to convert based on locale.
	 * @param int    $decimals  Optional. Precision of the number of decimal places. Default 0.
	 *
	 * @return string Converted number in string format.
	 * @global WP_Locale $wp_locale
	 */
	public function maybe_fix_multibyte_number_format( $formatted, $number, $decimals ) {
		global $wp_locale;

		if ( empty( $wp_locale ) ) {
			return $formatted;
		}

		$dec_point     = $wp_locale->number_format['decimal_point'];
		$thousands_sep = $wp_locale->number_format['thousands_sep'];

		if ( 1 === strlen( $dec_point ) && 1 === strlen( $thousands_sep ) ) {
			return $formatted;
		}

		$formatted = number_format( $number, $decimals, 'd', 't' );

		$formatted = strtr(
			$formatted,
			array(
				'd' => $dec_point,
				't' => $thousands_sep,
			)
		);

		return $formatted;
	}

	/**
	 * Test default format.
	 *
	 * @link         https://github.com/WordPress/WordPress/blob/4.9.5/wp-includes/l10n.php
	 *
	 * @dataProvider default_format_provider
	 *
	 * @param string $locale   Locale to test.
	 * @param string $expected Expected default format.
	 */
	public function test_default_format( $locale, $expected ) {
		switch_to_locale( $locale );

		$value = Money::get_default_format();

		$this->assertEquals( $locale, get_locale() );
		$this->assertEquals( $expected, $value );
	}

	/**
	 * Default format provider.
	 *
	 * @return array
	 */
	public function default_format_provider() {
		return array(
			array( 'en_US', '%1$s%2$s %3$s' ),
			array( 'fr_FR', '%1$s%2$s %3$s' ),
			array( 'nl_NL', '%1$s %2$s' ),
		);
	}

	/**
	 * Test format i18n.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/4.9.5/wp-includes/l10n.php
	 *
	 * @param string $locale   Locale.
	 * @param string $currency Money currency.
	 * @param float  $value    Money value.
	 * @param string $expected Expected format.
	 *
	 * @dataProvider format_i18n_provider
	 */
	public function test_format_i18n( $locale, $currency, $value, $expected ) {
		switch_to_locale( $locale );

		$money = new Money( $value, $currency );

		$string = $money->format_i18n();

		$this->assertEquals( $locale, get_locale() );
		/* translators: 1: currency symbol, 2: amount value, 3: currency code, note: use non-breaking space! */
		$this->assertEquals( $expected, $string, 'Locale: ' . get_locale() . ' Money format: ' . Money::get_default_format() . ' Test: ' . _x( '%1$s%2$s %3$s', 'money format', 'pronamic-money' ) );
	}

	/**
	 * Format i18n provider.
	 *
	 * @return array
	 */
	public function format_i18n_provider() {
		return array(
			// Dutch.
			array( 'nl_NL', 'EUR', 49.7512, '€ 49,75' ),
			array( 'nl_NL', 'NLG', 49.7512, 'G 49,7512' ),
			array( 'nl_NL', 'USD', 49.7512, '$ 49,75' ),
			array( 'nl_NL', 'USD', 1234567890.1234, '$ 1.234.567.890,12' ),

			// English.
			array( 'en_US', 'EUR', 49.7512, '€49.75 EUR' ),
			array( 'en_US', 'USD', 1234567890.1234, '$1,234,567,890.12 USD' ),

			// French.
			array( 'fr_FR', 'USD', 1234567890.1234, '$1 234 567 890,12 USD' ),
		);
	}

	/**
	 * Test format i18n without trailing zeros.
	 *
	 * @link         https://github.com/WordPress/WordPress/blob/4.9.5/wp-includes/l10n.php
	 *
	 * @param string $locale   Locale.
	 * @param string $currency Money currency.
	 * @param float  $value    Money value.
	 * @param string $expected Expected format.
	 *
	 * @dataProvider format_i18n_non_trailing_zeros_provider
	 */
	public function test_format_i18n_non_trailing_zeros( $locale, $currency, $value, $expected ) {
		switch_to_locale( $locale );

		$money = new Money( $value, $currency );

		$string = $money->format_i18n_non_trailing_zeros();

		$this->assertEquals( $locale, get_locale() );

		/* translators: 1: currency symbol, 2: amount value, 3: currency code, note: use non-breaking space! */
		$this->assertEquals( $expected, $string, 'Locale: ' . get_locale() . ' Money format: ' . Money::get_default_format() . ' Test: ' . _x( '%1$s%2$s %3$s', 'money format', 'pronamic-money' ) );
	}

	/**
	 * Format i18n without trailing zeros provider.
	 *
	 * @return array
	 */
	public function format_i18n_non_trailing_zeros_provider() {
		return array(
			// Dutch.
			array( 'nl_NL', 'EUR', 49.7512, '€ 49,75' ),
			array( 'nl_NL', 'NLG', 49, 'G 49' ),
			array( 'nl_NL', 'USD', 49.00, '$ 49' ),
			array( 'nl_NL', 'USD', 1234567890.00, '$ 1.234.567.890' ),

			// English.
			array( 'en_US', 'EUR', 49.7512, '€49.75 EUR' ),
			array( 'en_US', 'USD', 1234567890.00, '$1,234,567,890 USD' ),

			// French.
			array( 'fr_FR', 'USD', 1234567890, '$1 234 567 890 USD' ),
		);
	}

	/**
	 * Test minor units.
	 *
	 * @since 1.2.1
	 *
	 * @dataProvider minor_units_provider
	 *
	 * @param string    $currency Currency.
	 * @param int|float $value    Money value to test.
	 * @param int       $expected Expected value.
	 */
	public function test_minor_units( $currency, $value, $expected ) {
		$money = new Money( $value, $currency );

		$this->assertSame( $expected, $money->get_minor_units()->to_int() );
	}

	/**
	 * Minor units provider.
	 *
	 * @since 1.2.1
	 *
	 * @return array
	 */
	public function minor_units_provider() {
		return array(
			// Value 10.
			array( 'JPY', 10, 10 ),
			array( 'EUR', 10, 1000 ),
			array( 'BHD', 10, 10000 ),
			array( 'NLG', 10, 100000 ),

			// Value 100.65.
			array( 'JPY', 100.65, 100 ),
			array( 'EUR', 100.65, 10065 ),
			array( 'BHD', 100.65, 100650 ),
			array( 'NLG', 100.65, 1006500 ),

			// Value 100.655.
			array( 'JPY', 100.655, 100 ),
			array( 'EUR', 100.655, 10065 ),
			array( 'BHD', 100.655, 100655 ),
			array( 'NLG', 100.655, 1006550 ),

			// Value 0.00010.
			array( 'JPY', 0.00010, 0 ),
			array( 'EUR', 0.00010, 0 ),
			array( 'BHD', 0.00010, 0 ),
			array( 'NLG', 0.00010, 1 ),
		);
	}

	/**
	 * Test add.
	 *
	 * @since 1.3.0
	 */
	public function test_add() {
		$money_1 = new Money( 99.75, 'EUR' );

		$money_2 = new Money( 0.25, 'EUR' );

		$money_3 = $money_1->add( $money_2 );

		$this->assertEquals( 100, $money_3->get_value() );
	}

	/**
	 * Test JSON.
	 */
	public function test_json() {
		$money = new Money( 99.75, 'EUR' );

		$this->assertJsonStringEqualsJsonString( '
			{
				"value": "99.75",
				"currency": "EUR"
			}
			',
			\wp_json_encode( $money )
		);
	}

	/**
	 * Test number format.
	 */
	public function test_number_format() {
		$money = new Money( 12345678.90, 'EUR' );

		$this->assertSame( '12345678.90', $money->number_format( null, '.', '' ) );
		$this->assertSame( '12,345,678.90', $money->number_format( null, '.', ',' ) );
		$this->assertSame( '12345678.9', $money->number_format( 1, '.', '' ) );
	}

	/**
	 * Test number format i18n.
	 */
	public function test_number_format_i18n() {
		\switch_to_locale( 'en_US' );

		$money = new Money( 12345678.90, 'EUR' );

		$this->assertSame( '12,345,678.90', $money->number_format_i18n( null ) );
		$this->assertSame( '12,345,678.9', $money->number_format_i18n( 1 ) );
	}

	/**
	 * Test multiply.
	 */
	public function test_multiply() {
		$money = new Money( '123', 'EUR' );

		$money_2 = $money->multiply( 2 );

		$this->assertSame( '246.00', $money_2->number_format( null, '.', '' ) );
	}

	/**
	 * Test divide.
	 */
	public function test_divide() {
		$money = new Money( '246', 'EUR' );

		$money_2 = $money->divide( 2 );

		$this->assertSame( '123.00', $money_2->number_format( null, '.', '' ) );
	}

	/**
	 * Test absolute.
	 */
	public function test_absolute() {
		$money = new Money( '-123', 'EUR' );

		$this->assertSame( '-123.00', $money->number_format( null, '.', '' ) );

		$money_2 = $money->absolute();
		
		$this->assertSame( '123.00', $money_2->number_format( null, '.', '' ) );
	}
}
