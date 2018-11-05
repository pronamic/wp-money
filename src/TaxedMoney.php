<?php
/**
 * Taxed Money
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2018 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

/**
 * Taxed Money
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class TaxedMoney extends Money {
	/**
	 * Tax amount.
	 *
	 * @var float|null
	 */
	private $tax_amount;

	/**
	 * Tax percentage.
	 *
	 * @var float|null
	 */
	private $tax_percentage;

	/**
	 * Construct and initialize money object.
	 *
	 * @param string|int|float     $amount   Amount.
	 * @param Currency|string|null $currency Currency.
	 */
	public function __construct( $amount = 0, $currency = null, $tax_amount = null, $tax_percentage = null ) {
		parent::__construct( $amount, $currency );

		$this->set_tax_amount( $tax_amount );
		$this->set_tax_percentage( $tax_percentage );
	}

	/**
	 * Get tax amount.
	 *
	 * @return float Tax amount.
	 */
	public function get_tax_amount() {
		return $this->tax_amount;
	}

	/**
	 * Set tax amount.
	 *
	 * @param mixed $amount Tax amount.
	 */
	public function set_tax_amount( $amount ) {
		$this->tax_amount = floatval( $amount );
	}

	/**
	 * Get tax percentage.
	 *
	 * @return float
	 */
	public function get_tax_percentage() {
		return $this->tax_percentage;
	}

	/**
	 * Set tax percentage.
	 *
	 * @param mixed $tax_percentage Tax percentage.
	 */
	public function set_tax_percentage( $percentage ) {
		$this->tax_percentage = floatval( $percentage );
	}

	/**
	 * Get including tax.
	 *
	 * @return Money
	 */
	public function get_including_tax() {
		return new Money( $this->get_amount(), $this->get_currency() );
	}

	/**
	 * Get excluding tax.
	 *
	 * @return Money
	 */
	public function get_excluding_tax() {
		$value = $this->get_amount();

		if ( null !== $this->get_tax_amount() ) {
			$value -= $this->get_tax_amount();
		}

		return new Money( $value, $this->get_currency() );
	}
}
