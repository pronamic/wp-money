<?php
/**
 * Taxed Money Test
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
 * Taxed Money Test
 *
 * @author Remco Tolsma
 * @version 1.2.2
 * @since   1.0.0
 */
class TaxedMoneyTest extends WP_UnitTestCase {
	/**
	 *  Test taxed money.
	 */
	public function test_taxed_money() {
		$money = new TaxedMoney( '121', 'EUR', '21', '21' );

		$this->assertSame( '21.00', $money->get_tax_amount()->number_format( null, '.', '' ) );
		$this->assertSame( '21', $money->get_tax_value() );
		$this->assertTrue( $money->has_tax() );
		$this->assertSame( '21', $money->get_tax_percentage() );
		$this->assertSame( '121.00', $money->get_including_tax()->number_format( null, '.', '' ) );
		$this->assertSame( '100.00', $money->get_excluding_tax()->number_format( null, '.', '' ) );
	}

	/**
	 *  Test tax percentage calculation from tax value.
	 */
	public function test_tax_value_calculation_from_tax_percentage() {
		$money = new TaxedMoney( '121', 'EUR', null, '21' );

		$this->assertSame( '21', $money->get_tax_value() );
	}

	/**
	 * Test JSON.
	 */
	public function test_json() {
		$money = new TaxedMoney( '121', 'EUR', null, '21' );

		$this->assertJsonStringEqualsJsonString(
			'
			{
				"value": "121",
				"currency": "EUR",
				"tax_value": "21",
				"tax_percentage": "21"
			}
			',
			\wp_json_encode( $money )
		);
	}

	/**
	 * Test no tax.
	 */
	public function test_no_tax() {
		$money = new TaxedMoney( '121', 'EUR' );

		$this->assertFalse( $money->has_tax() );
		$this->assertNull( $money->get_tax_amount() );
		$this->assertSame( '121.00', $money->get_excluding_tax()->number_format( null, '.', '' ) );
	}
}
