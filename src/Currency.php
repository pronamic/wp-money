<?php
/**
 * Currency
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2018 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

/**
 * Currency
 *
 * @author Remco Tolsma
 * @version 1.0
 */
class Currency {
	/**
	 * Code.
	 *
	 * @var string
	 */
	private $code;

	/**
	 * Symbol.
	 *
	 * @var string
	 */
	private $symbol;

	/**
	 * Name.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Number decimals.
	 *
	 * @var int
	 */
	private $number_decimals;

	/**
	 * Construct and initialize currency object.
	 *
	 * @var string $code
	 * @var string $symbol
	 * @var string $name
	 * @var int    $number_decimals
	 */
	public function __construct( $code, $symbol, $name, $number_decimals = 2 ) {
		$this->code            = $code;
		$this->symbol          = $symbol;
		$this->name            = $name;
		$this->number_decimals = $number_decimals;
	}
}
