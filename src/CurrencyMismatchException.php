<?php
/**
 * Currency Mismatch Exception
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2026 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Money;

/**
 * Currency Mismatch Exception
 *
 * @author Remco Tolsma
 */
class CurrencyMismatchException extends \InvalidArgumentException {
	/**
	 * Create a new currency mismatch exception.
	 *
	 * @param Currency $a First currency.
	 * @param Currency $b Second currency.
	 * @return self
	 */
	public static function create( Currency $a, Currency $b ): self {
		return new self(
			\sprintf(
				'Cannot perform arithmetic operation on Money objects with different currencies: %s and %s.',
				$a->get_alphabetic_code(),
				$b->get_alphabetic_code()
			)
		);
	}
}
