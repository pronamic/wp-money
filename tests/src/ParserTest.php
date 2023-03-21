<?php
/**
 * Parser
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * Parser
 *
 * @author  Remco Tolsma
 * @version 1.2.5
 * @since   1.1.0
 */
class ParserTest extends TestCase {
	/**
	 * Parser.
	 *
	 * @var Parser
	 */
	private $parser;

	/**
	 * Setup.
	 */
	public function set_up() {
		parent::set_up();

		$this->parser = new Parser();
	}

	/**
	 * Test string to amount.
	 *
	 * @link https://github.com/pronamic/wp-pronamic-ideal/blob/3.7.3/classes/Pronamic/WP/Pay/Settings.php#L71-L91
	 * @link https://github.com/WordPress/WordPress/blob/4.9.6/wp-includes/class-wp-locale.php
	 * @link https://github.com/WordPress/WordPress/blob/4.9.6/wp-includes/functions.php#L206-L237
	 *
	 * @dataProvider string_to_amount_provider
	 *
	 * @param string $thousands_sep Thousands seperator.
	 * @param string $decimal_sep   Decimal seperator.
	 * @param string $string        String value to convert.
	 * @param float  $expected      Expected float value.
	 */
	public function test_string_to_amount( $thousands_sep, $decimal_sep, $string, $expected ) {
		global $wp_locale;

		$wp_locale->number_format['thousands_sep'] = $thousands_sep;
		$wp_locale->number_format['decimal_point'] = $decimal_sep;

		try {
			$money = $this->parser->parse( $string );

			$value = $money->get_value();
		} catch ( \Exception $e ) {
			$value = null;
		}

		$this->assertEquals( $expected, $value );
	}

	/**
	 * String to amount provider.
	 *
	 * @return array
	 */
	public function string_to_amount_provider() {
		return [
			// Thousands separator is '' and decimal separator is '.'.
			[ '', '.', '1', 1 ],
			[ '', '.', '2,5', 2.5 ],
			[ '', '.', '2,50', 2.5 ],
			[ '', '.', '1250,00', 1250 ],
			[ '', '.', '1250,75', 1250.75 ],
			[ '', '.', '1250.75', 1250.75 ],
			[ '', '.', '1.250,00', 1250 ],
			[ '', '.', '2.500,75', 2500.75 ],
			[ '', '.', '2500,75-', -2500.75 ],
			[ '', '.', '-2500,75', -2500.75 ],
			[ '', '.', '2500-', -2500 ],
			[ '', '.', '-2500', -2500 ],
			[ '', '.', '1-', -1 ],
			// Thousands separator is '.' and decimal separator is ','.
			[ '.', ',', '1', 1 ],
			[ '.', ',', '2,5', 2.5 ],
			[ '.', ',', '2,50', 2.5 ],
			[ '.', ',', '1250,00', 1250 ],
			[ '.', ',', '2500,75', 2500.75 ],
			[ '.', ',', '1.250,00', 1250 ],
			[ '.', ',', '2.500,75', 2500.75 ],
			[ '.', ',', '2.500,750', 2500.75 ],
			[ '.', ',', '1.234.567.890', 1234567890 ],
			[ '.', ',', '2.500,75-', -2500.75 ],
			[ '.', ',', '-2.500,75', -2500.75 ],
			[ '.', ',', '2.500-', -2500 ],
			[ '.', ',', '-2.500', -2500 ],
			[ '.', ',', '1-', -1 ],
			// Thousands separator is ',' and decimal separator is '.'.
			[ ',', '.', '1', 1 ],
			[ ',', '.', '2.5', 2.5 ],
			[ ',', '.', '2.50', 2.5 ],
			[ ',', '.', '1250.00', 1250 ],
			[ ',', '.', '1250.75', 1250.75 ],
			[ ',', '.', '1,250.00', 1250 ],
			[ ',', '.', '2,500.75', 2500.75 ],
			[ ',', '.', '2,500.', 2500 ],
			[ ',', '.', '2,500.75-', -2500.75 ],
			[ ',', '.', '-2,500.75', -2500.75 ],
			[ ',', '.', '2,500-', -2500 ],
			[ ',', '.', '-2,500', -2500 ],
			[ ',', '.', '1-', -1 ],
			// Thousands separator is ' ' and decimal separator is '.'.
			[ ' ', '.', '2 500.75', 2500.75 ],
			// Thousands separator is 't' and decimal separator is '.'.
			[ 't', '.', '2t500.75', 2500.75 ],
			[ 't', '.', '2t500.7', 2500.7 ],
			// Thousands separator is 't' and decimal separator is '-'.
			[ 't', '-', '2t500-75', 2500.75 ],
			[ 't', '-', '2t500-7', 2500.7 ],
			// Thousands separator is 't' and decimal separator is ' '.
			[ 't', ' ', '2t500 75', 2500.75 ],
			[ 't', ' ', '2t500 7', 2500.7 ],
			// Thousands separator is ' ' and decimal separator is 'd'.
			[ ' ', 'd', '2 500d75', 2500.75 ],
			[ ' ', 'd', '2 500d7', 2500.7 ],
			[ ' ', 'd', '-2 500d75', -2500.75 ],
			[ ' ', 'd', '-2 500d7', -2500.7 ],
			// Other.
			[ '.', ',', 'EUR 1.250', 1250 ],
			[ '.', ',', 'EUR 1.250,75', 1250.75 ],
			[ '.', ',', 'EUR -1.250', -1250 ],
			[ '.', ',', 'EUR -1.250,75', -1250.75 ],
			[ '.', ',', '1.250,-', 1250 ],
			[ '.', ',', '-1.250,-', -1250 ],
			[ '', '', '123456789', 123456789 ],
			[ false, false, '123 456 789', 123456789 ],
		];
	}
}
