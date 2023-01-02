<?php
/**
 * Currencies Test
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
 * Currencies Test
 *
 * @author Remco Tolsma
 * @version 1.2.2
 * @since   1.0.0
 */
class CurrenciesTest extends WP_UnitTestCase {
	/**
	 * Test unknwon currency.
	 */
	public function test_unknown_currency() {
		$alphabetic_code = 'XYZ';

		$currency = Currencies::get_currency( $alphabetic_code );

		$this->assertSame( 'XYZ', $currency->get_alphabetic_code() );
		$this->assertSame( 2, $currency->get_number_decimals() );
	}
}
