# Change Log

All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [Unreleased][unreleased]
-

## [2.4.3] - 2023-11-06

### Commits

- Removed unnecessary space after "Comorian Franc". ([e5b195b](https://github.com/pronamic/wp-money/commit/e5b195b446c36721c241863549b8a5e64d82a14f))

Full set of changes: [`2.4.2...2.4.3`][2.4.3]

[2.4.3]: https://github.com/pronamic/wp-money/compare/v2.4.2...v2.4.3

## [2.4.2] - 2023-10-30

### Commits

- Removed Grunt. ([129e649](https://github.com/pronamic/wp-money/commit/129e6499fe0d72ec9a1d22983dc7629301d54609))
- Added `if ( ! defined( 'ABSPATH' ) )`. ([1bcefb8](https://github.com/pronamic/wp-money/commit/1bcefb81b389108c8d9a06d109afe2b16e8edf31))

Full set of changes: [`2.4.1...2.4.2`][2.4.2]

[2.4.2]: https://github.com/pronamic/wp-money/compare/v2.4.1...v2.4.2

## [2.4.1] - 2023-09-11

### Commits

- Ignore /docs folder. ([7867afd](https://github.com/pronamic/wp-money/commit/7867afd50117a18cf97d4959b7f42fdc2abfd291))

Full set of changes: [`2.4.0...2.4.1`][2.4.1]

[2.4.1]: https://github.com/pronamic/wp-money/compare/v2.4.0...v2.4.1

## [2.4.0] - 2023-03-21

### Commits

- Added `is_zero()` function. ([0ebce4a](https://github.com/pronamic/wp-money/commit/0ebce4a2e13682228d7f9bb79148d42e23fd74cc))

Full set of changes: [`2.3.0...2.4.0`][2.4.0]

[2.4.0]: https://github.com/pronamic/wp-money/compare/v2.3.0...v2.4.0

## [2.3.0] - 2023-03-21

### Commits

- Set Composer type to "wordpress-plugin". ([1951851](https://github.com/pronamic/wp-money/commit/19518518e55f18f22b484bde57e042da83c7a0af))
- Added `negative` function. ([69f7343](https://github.com/pronamic/wp-money/commit/69f73439f1488108614d6737cc5703fdb25a68f3))
- Use `Yoast/PHPUnit-Polyfills`. ([f100606](https://github.com/pronamic/wp-money/commit/f1006062f967856dfb52d296999fdbf76a0aeac7))
- Created .gitattributes ([dc50445](https://github.com/pronamic/wp-money/commit/dc50445c58349e483d27a52755a6944afd650da4))

### Composer

- Changed `pronamic/wp-number` from `^1.2` to `v1.3.0`.
	Release notes: https://github.com/pronamic/wp-number/releases/tag/v1.3.0

Full set of changes: [`2.2.1...2.3.0`][2.3.0]

[2.3.0]: https://github.com/pronamic/wp-money/compare/v2.2.1...v2.3.0

## [2.2.1] - 2023-01-31
### Composer

- Changed `php` from `>=8.0` to `>=7.4`.
Full set of changes: [`2.2.0...2.2.1`][2.2.1]

[2.2.1]: https://github.com/pronamic/wp-money/compare/v2.2.0...v2.2.1

## [2.2.0] - 2022-12-19
- Update `pronamic/wp-number` to version `^1.2`.
Full set of changes: [`2.1.0...2.2.0`][2.2.0]

[2.2.0]: https://github.com/pronamic/wp-money/compare/2.1.0...2.2.0

## [2.1.0] - 2022-12-19
- Increased minimum PHP version to version `8` or higher.
- Improved support for PHP `8.1` and `8.2`.
- Removed usage of deprecated constant `FILTER_SANITIZE_STRING`.

Full set of changes: [`2.0.3...2.1.0`][2.1.0]

[2.1.0]: https://github.com/pronamic/wp-money/compare/2.0.3...2.1.0

## [2.0.3] - 2022-09-27
- Update plugin version number.

## [2.0.2] - 2022-09-23
- Coding standards.

## [2.0.1] - 2022-01-10
### Changed
- Updated `pronamic/wp-number` library to version `1.1.0`.

## [2.0.0] - 2021-08-05
### Changed
- Use `pronamic/wp-number` library.
- Simplified JSON, always include currency, without it's just a number value.
- Function `get_minor_units` will now return a `Number` object.
- No longer use i18n in the 'normal' `format()` funciton.
- Validate alphabetic code.

### Added
- Added money amount number format helper functions.
- Added taxed money test.
- Added test for unknown currency.

### Removed
- Removed deprecated `get_cents` function.

## [1.2.6] - 2021-04-26
- Happy 2021.
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

[unreleased]: https://github.com/pronamic/wp-money/compare/2.0.3...HEAD
[2.0.3]: https://github.com/pronamic/wp-money/compare/2.0.2...2.0.3
[2.0.2]: https://github.com/pronamic/wp-money/compare/2.0.1...2.0.2
[2.0.1]: https://github.com/pronamic/wp-money/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/pronamic/wp-money/compare/1.2.6...2.0.0
[1.2.6]: https://github.com/pronamic/wp-money/compare/1.2.5...1.2.6
[1.2.5]: https://github.com/pronamic/wp-money/compare/1.2.4...1.2.5
[1.2.4]: https://github.com/pronamic/wp-money/compare/1.2.3...1.2.4
[1.2.3]: https://github.com/pronamic/wp-money/compare/1.2.2...1.2.3
[1.2.2]: https://github.com/pronamic/wp-money/compare/1.2.1...1.2.2
[1.2.1]: https://github.com/pronamic/wp-money/compare/1.2.0...1.2.1
[1.2.0]: https://github.com/pronamic/wp-money/compare/1.1.0...1.2.0
[1.1.0]: https://github.com/pronamic/wp-money/compare/1.0.0...1.1.0
