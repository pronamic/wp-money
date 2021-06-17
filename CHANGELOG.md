# Change Log

All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [Unreleased][unreleased]
-

## [1.2.6] - 2021-04-26
- Happy 2021.

## [1.2.6] - 2021-01-14
- composer bin all update
- Added GitHub action Super-Linter.
-  Fix Psalm issues.
- Remove Travis hhvm test.

## [1.2.5] - 2020-07-08
- Added support for parsing negative amounts and `5,-` notation for amounts without minor units.
- Updated currency symbols.

## [1.2.4] - 2020-02-03
- Return cloned object in calculator methods.

## [1.2.3] - 2019-12-18
- Fix calling method on string in subtraction.
- Use non-locale aware float values.

## [1.2.2] - 2019-07-22
- Fix floating point precision issue when converting to cents.
- Add method `Money::format()` which uses the number of decimals from currency.
- Add method `Money::format_i18n_non_trailing_zeros()` and `%2$NTZ` formatting directive.
- Add calculator classes and functions.
- Add ISO 4217 currencies.
- Deprecate `Money::get_cents()` in favor of `Money::get_minor_units()`.
- Require PHP >= 5.6.20.

## [1.2.1] - 2019-03-27
- Added `get_minor_units` method based on decimals of currency.
- Updated copyright to 2005-2019 Pronamic.

## [1.2.0] - 2018-12-10
- Added a `get_cents` method.
- Introduced a TaxedMoney class.
- Renamed `amount` to `value`.

## [1.1.0] - 2018-08-16
- Added a money parser class.

## 1.0.0
- First release.

[unreleased]: https://github.com/pronamic/wp-money/compare/1.2.6...HEAD
[1.2.6]: https://github.com/pronamic/wp-money/compare/1.2.5...1.2.6
[1.2.6]: https://github.com/pronamic/wp-money/compare/1.2.5...1.2.6
[1.2.5]: https://github.com/pronamic/wp-money/compare/1.2.4...1.2.5
[1.2.4]: https://github.com/pronamic/wp-money/compare/1.2.3...1.2.4
[1.2.3]: https://github.com/pronamic/wp-money/compare/1.2.2...1.2.3
[1.2.2]: https://github.com/pronamic/wp-money/compare/1.2.1...1.2.2
[1.2.1]: https://github.com/pronamic/wp-money/compare/1.2.0...1.2.1
[1.2.0]: https://github.com/pronamic/wp-money/compare/1.1.0...1.2.0
[1.1.0]: https://github.com/pronamic/wp-money/compare/1.0.0...1.1.0
