<?php
/**
 * Currency Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

use WP_Locale;
use WP_UnitTestCase;

/**
 * Currency Test
 *
 * @author Remco Tolsma
 * @version 1.2.2
 * @since   1.0.0
 */
class CurrencyTest extends WP_UnitTestCase {
	/**
	 * Test Euro.
	 */
	public function test_euro() {
		$currency = Currencies::get_currency( 'EUR' );

		$this->assertSame( '978', $currency->get_numeric_code() );
		$this->assertSame( 'Euro', $currency->get_name() );
		$this->assertJsonStringEqualsJsonString( '"EUR"', \wp_json_encode( $currency ) );
	}

	/**
	 * Test invalid alphabetic code.
	 */
	public function test_invalid_alphabetic_code() {
		$alphabetic_code = 'ABCDEF';

		$this->expectException( \InvalidArgumentException::class );

		$currency = new Currency( 'ABCDEF' );
	}
}
