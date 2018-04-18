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
	public function test_format( $amount, $currency, $locale, $expected ) {
		switch_to_locale( $locale );

		$money = new Money( $amount, $currency );

		$value = $money->format_i18n();

		$this->assertEquals( $value, $expected );
	}

	public function format_provider() {
		return array(
			array( 49.7512, 'EUR', 'nl_NL', '€49,75 EUR' ),
			array( 49.7512, 'EUR', 'en_US', '€49.75 EUR' ),
			array( 49.7512, 'NLG', 'nl_NL', 'ƒ49,7512 NLG' ),
			array( 49.7512, 'USD', 'nl_NL', '$49,75 USD' ),
			array( 1234567890.1234, 'USD', 'nl_NL', '$1.234.567.890,12 USD' ),
			array( 1234567890.1234, 'USD', 'en_US', '$1,234,567,890.12 USD' ),
			array( 1234567890.1234, 'USD', 'fr_FR', '$1 234 567 890,12 USD' ),
		);
	}
}
