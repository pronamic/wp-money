<?php
/**
 * Taxed Money
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

use JsonSerializable;
use Pronamic\WordPress\Number\Number;

/**
 * Taxed Money
 *
 * @author Remco Tolsma
 * @version 2.0.0
 * @since   1.2.0
 */
class TaxedMoney extends Money {
	/**
	 * Tax value.
	 *
	 * @var Number|null
	 */
	private $tax_value;

	/**
	 * Tax percentage.
	 *
	 * @var Number|null
	 */
	private $tax_percentage;

	/**
	 * Construct and initialize money object.
	 *
	 * @param mixed                 $value          Amount value.
	 * @param Currency|string       $currency       Currency.
	 * @param float|int|string|null $tax_value      Tax value.
	 * @param mixed                 $tax_percentage Tax percentage.
	 */
	public function __construct( $value = 0, $currency = 'EUR', $tax_value = null, $tax_percentage = null ) {
		$value = Number::from_mixed( $value );

		parent::__construct( $value, $currency );

		// Calculate tax amount if tax percentage is set.
		if ( null === $tax_value && null !== $tax_percentage ) {
			$tax_percentage = Number::from_mixed( $tax_percentage );

			$percentage = Number::from_string( '100' );
			$percentage = $percentage->add( $tax_percentage );

			/**
			 * For some reason, Scrutinizer thinks the `add` function return a
			 * `int|double` in the `$percentage` variable.
			 *
			 * @scrutinizer ignore-type
			 */
			$one_percent_value = $value->divide( $percentage );

			$tax_value = (string) $one_percent_value->multiply( $tax_percentage );
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
	 * @return string|null
	 */
	public function get_tax_value() {
		return null === $this->tax_value ? null : $this->tax_value->get_value();
	}

	/**
	 * Set tax value.
	 *
	 * @param float|int|string|null $value Tax value.
	 * @return void
	 */
	public function set_tax_value( $value ) {
		$this->tax_value = ( null === $value ? null : Number::from_mixed( $value ) );
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
	 * @return string|null
	 */
	public function get_tax_percentage() {
		return null === $this->tax_percentage ? null : $this->tax_percentage->get_value();
	}

	/**
	 * Set tax percentage.
	 *
	 * 100% = 100
	 *  21% =  21
	 *   6% =   6
	 * 1.5% =   1.5
	 *
	 * @param mixed $percentage Tax percentage.
	 * @return void
	 */
	public function set_tax_percentage( $percentage ) {
		$this->tax_percentage = ( null === $percentage ? null : Number::from_mixed( $percentage ) );
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

	/**
	 * JSON serialize.
	 *
	 * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return object
	 */
	public function jsonSerialize(): object {
		$object = parent::jsonSerialize();

		$properties = (array) $object;

		if ( null !== $this->tax_value ) {
			$properties['tax_value'] = $this->tax_value->jsonSerialize();
		}

		if ( null !== $this->tax_percentage ) {
			$properties['tax_percentage'] = $this->tax_percentage->jsonSerialize();
		}

		$object = (object) $properties;

		return $object;
	}
}
