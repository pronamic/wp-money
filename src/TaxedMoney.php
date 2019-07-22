<?php
/**
 * Taxed Money
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2019 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

/**
 * Taxed Money
 *
 * @author Remco Tolsma
 * @version 1.2.2
 * @since   1.2.0
 */
class TaxedMoney extends Money {
	/**
	 * Tax value.
	 *
	 * @var float|null
	 */
	private $tax_value;

	/**
	 * Tax percentage.
	 *
	 * @var float|null
	 */
	private $tax_percentage;

	/**
	 * Construct and initialize money object.
	 *
	 * @param string|int|float $value          Amount value.
	 * @param Currency|string  $currency       Currency.
	 * @param string|int|float $tax_value      Tax value.
	 * @param string|int|float $tax_percentage Tax percentage.
	 */
	public function __construct( $value = 0, $currency = 'EUR', $tax_value = null, $tax_percentage = null ) {
		parent::__construct( $value, $currency );

		// Calculate tax amount if tax percentage is set.
		if ( null === $tax_value && null !== $tax_percentage ) {
			$calculator = $this->get_calculator();

			$one_percent_value = $calculator->divide( strval( $value ), $calculator->add( strval( 100 ), strval( $tax_percentage ) ) );

			$tax_value = $calculator->multiply( strval( $one_percent_value ), $tax_percentage );
		}

		$this->set_tax_value( $tax_value );
		$this->set_tax_percentage( $tax_percentage );
	}

	/**
	 * Get tax amount.
	 *
	 * @return Money|null Tax amount.
	 */
	public function get_tax_amount() {
		if ( null === $this->tax_value ) {
			return null;
		}

		return new Money( $this->tax_value, $this->get_currency() );
	}

	/**
	 * Get tax value.
	 *
	 * @return float|null
	 */
	public function get_tax_value() {
		return $this->tax_value;
	}

	/**
	 * Set tax value.
	 *
	 * @param float|int|string|null $value Tax value.
	 * @return void
	 */
	public function set_tax_value( $value ) {
		$this->tax_value = ( null === $value ? null : floatval( $value ) );
	}

	/**
	 * Has tax?
	 *
	 * @return bool
	 */
	public function has_tax() {
		return ( null !== $this->get_tax_value() );
	}

	/**
	 * Get tax percentage.
	 *
	 * @return float|null
	 */
	public function get_tax_percentage() {
		return $this->tax_percentage;
	}

	/**
	 * Set tax percentage.
	 *
	 * 100% = 100
	 *  21% =  21
	 *   6% =   6
	 * 1.5% =   1.5
	 *
	 * @param string|int|float|null $percentage Tax percentage.
	 * @return void
	 */
	public function set_tax_percentage( $percentage ) {
		$this->tax_percentage = ( null === $percentage ? null : floatval( $percentage ) );
	}

	/**
	 * Get including tax.
	 *
	 * @return Money
	 */
	public function get_including_tax() {
		return new Money( $this->get_value(), $this->get_currency() );
	}

	/**
	 * Get excluding tax.
	 *
	 * @return Money
	 */
	public function get_excluding_tax() {
		$tax_amount = $this->get_tax_amount();

		if ( null === $tax_amount ) {
			return $this->get_including_tax();
		}

		return $this->subtract( $tax_amount );
	}
}
