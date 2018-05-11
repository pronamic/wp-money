# WordPress Money

## Non-breaking space

In the money format it is smart to use a non-breaking space:

> In word processing and digital typesetting, a non-breaking space (" "), also called no-break space, non-breakable space (NBSP), hard space,
> or fixed space, is a space character that prevents an automatic line break at its position.

Source: https://en.wikipedia.org/wiki/Non-breaking_space#Keyboard_entry_method

## WordPress Filters

### pronamic_money_default_format

```php
function prefix_pronamic_money_default_format( $format ) {
	/* translators: 1: currency symbol, 2: amount, 3: currency code */
	return _x( '%1$s%2$s', 'default money format', 'pronamic-ideal' );
}

add_filter( 'pronamic_money_default_format', 'prefix_pronamic_money_default_format' );
```

## Inspiration

*	https://github.com/datasets/currency-codes
*	https://github.com/cknow/laravel-money
*	https://github.com/akaunting/money
*	https://github.com/moneyphp/money
*	https://github.com/Torann/laravel-currency
*	https://github.com/davidkalosi/js-money
*	https://github.com/scurker/currency.js
*	https://github.com/woocommerce/woocommerce/blob/3.3.5/includes/wc-core-functions.php#L284-L464
*	https://github.com/woocommerce/woocommerce/blob/3.3.5/i18n/locale-info.php
*	http://trigeminal.fmsinc.com/samples/setlocalesample2.asp
*	http://moneyphp.org/
*	https://packagist.org/?q=money
*	https://packagist.org/?q=currency
*	https://yarnpkg.com/en/packages?q=money
*	https://yarnpkg.com/en/packages?q=currency
*	https://www.currency-iso.org/en/home.html
*	https://docs.oracle.com/javase/7/docs/api/java/util/Currency.html
*	https://wp-languages.github.io/
