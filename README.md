# WordPress Money

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
*	https://github.com/woocommerce/woocommerce/blob/3.3.5/i18n/locale-info.php
*	http://trigeminal.fmsinc.com/samples/setlocalesample2.asp
*	http://moneyphp.org/
*	https://packagist.org/?q=money
*	https://packagist.org/?q=currency
*	https://yarnpkg.com/en/packages?q=money
*	https://yarnpkg.com/en/packages?q=currency
*	https://www.currency-iso.org/en/home.html
