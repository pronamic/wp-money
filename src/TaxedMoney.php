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
	 * @param string|int|float     $amount         Amount.
	 * @param Currency|string|null $currency       Currency.
	 * @param string|int|float     $tax_amount     Tax amount.
	 * @param string|int|float     $tax_percentage Tax percentage.
	 */
	public function __construct( $amount = 0, $currency = null, $tax_amount = null, $tax_percentage = null ) {
		parent::__construct( $amount, $currency );

		// Calculate tax amount if tax percentage is set.
		if ( null === $tax_amount && null !== $tax_percentage ) {
			$tax_amount = ( $amount / ( 100 + $tax_percentage ) ) * $tax_percentage;
		}

		$this->set_tax_amount( $tax_amount );

		// Calculate tax percentage if tax amount is set.
		if ( null === $tax_percentage && null !== $tax_amount && $amount > 0 ) {
			$tax_percentage = round( ( $tax_amount / ( $amount - $tax_amount ) ) * 100, 2 );
		}

		$this->set_tax_percentage( $tax_percentage );
	}

	/**
	 * Get tax amount.
	 *
	 * @return float|null Tax amount.
	 */
	public function get_tax_amount() {
		return $this->tax_amount;
	}

	/**
	 * Set tax amount.
	 *
	 * @param float|null $amount Tax amount.
	 */
	public function set_tax_amount( $amount ) {
		$this->tax_amount = ( null === $amount ? null : floatval( $amount ) );
	}

	/**
	 * Has tax?
	 *
	 * @return bool
	 */
	public function has_tax() {
		return ( null !== $this->get_tax_amount() );
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
	 * 100% = 100
	 *  21% =  21
	 *   6% =   6
	 * 1.5% =   1.5
	 *
	 * @param string|int|float|null $percentage Tax percentage.
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
		return new Money( $this->get_amount(), $this->get_currency() );
	}

	/**
	 * Get excluding tax.
	 *
	 * @return Money
	 */
	public function get_excluding_tax() {
		$amount = $this->get_amount();

		$use_bcmath = extension_loaded( 'bcmath' );

		if ( $use_bcmath ) {
			// Use non-locale aware float value.
			// @link http://php.net/sprintf.
			$value = sprintf( '%F', $this->get_amount() );

			$amount = bcsub( $value, $this->get_tax_amount(), 8 );
		} else {
			$amount -= $this->get_tax_amount();
		}

		return new Money( $amount, $this->get_currency() );
	}
}
