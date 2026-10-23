# Changelog

All notable changes to `loyverse-sdk` will be documented in this file

## 4.0.0 - 2026-10-23

### Added

- PHPStan level 8 configuration and CI job.
- Pint configuration and CI job.
- `Scope` enum replacing the `Scopes` class.
- `retry()` is deprecated in favour of `retryOnRateLimit()`.

### Changed

- Minimum PHP version is now **8.4**.
- Guzzle **8** is required; Guzzle 7 support has been dropped.
- `AccessToken` is now `final` and uses promoted readonly properties.
- All source and test files use `declare(strict_types=1)`.
- Modernized code with `mixed`, `never`, `static`, `match` and `#[\SensitiveParameter]`.
- Tests and configuration upgraded to PHPUnit 13.
- CI tests PHP 8.4 and 8.5, plus PHPStan and Pint jobs.
- Removed redundant `ext-json` and `ext-hash` requirements.
- Fixed the author email address.

## 3.0.0 - 2026-10-23

### Added

- Automatic pagination with `Loyverse::paginate()`.
- OAuth 2.0 support (`OAuth`, `AccessToken`, `Scopes`).
- Webhook signature verification (`WebhookSignature`).
- Rate limit retries with `Loyverse::retryOnRateLimit()`.
- Nested receipt models: `ReceiptLineItem`, `ReceiptLineTax`, `ReceiptLineDiscount`,
  `ReceiptLineModifier`, `ReceiptTotalDiscount`, `ReceiptTotalTax`, `ReceiptPayment`.
- `ItemComponent` model for composite items.

### Changed

- All list methods now return `['<resource>' => Resource[], 'cursor' => ?string]`.
- `inventory()` now returns a page array; `updateInventory()` still returns `Inventory`.
- `Receipt::$lineItems`, `$totalDiscounts`, `$totalTaxes` and `$payments`
  are hydrated into resource objects.
- `Item::$components` is hydrated into `ItemComponent` objects.
- `Receipt::$tip` and `Receipt::$surcharge` are now `float`.
- `Shift::$closedAt`, `$closedByEmployee`, `$actualCash` and `Store::$state`, `$country`
  are nullable.

### Dependencies

- Guzzle 8 is now supported in addition to Guzzle 7 (`^7.2|^8.0`).
- Added the `ext-hash` requirement for webhook signature verification.
- Updated dev dependencies to Mockery `^1.6` and PHPUnit `^9.6`.

## 2.1.0 - 2026-10-23

### Added

- Item image upload and delete methods (`uploadItemImage`, `deleteItemImage`,
  `Item::uploadImage`, `Item::deleteImage`).
- Raw request helpers (`requestRaw`, `postRaw`).
- `ModifierOption` timestamps (`createdAt`, `updatedAt`, `deletedAt`).
- `Inventory` cursor.
- API error context on exceptions: status, error code, details, field and the full
  list of errors.
- `getRetryAfter()` for rate limited requests.

### Fixed

- `Variant::update()` now sends `variant_id` instead of `id`.
- Successful responses with any `2xx` status are no longer treated as errors.
- `setTimeout()` is now applied to HTTP requests.
- Empty JSON objects and arrays are decoded correctly.
- `TimeoutException` constructor is explicitly nullable for PHP 8.4+.
- Implicitly nullable resource constructors are explicitly nullable for PHP 8.4+.

## 1.0.0 - 201X-XX-XX

- initial release
