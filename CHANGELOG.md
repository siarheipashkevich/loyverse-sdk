# Changelog

All notable changes to `loyverse-sdk` will be documented in this file

## 4.5.0 - 2026-10-23

### Added

- Opt-in `Paginator` via `Loyverse::page()` with `lazy()`, `lazyPages()`, `nextPage()`,
  `toArray()` and JSON serialization.
- DTOs: `CreateReceiptData`, `RefundReceiptData`, `InventoryUpdate` and `CreateItemData`.
- Examples for the paginator and receipt DTO.

### Changed

- Resource hydration now skips `null` for non-nullable typed properties and coerces
  scalar values to the declared property type.
- Unknown fields remain available as dynamic properties.

## 4.4.0 - 2026-10-23

### Added

- PHPStan configuration for the test suite.
- Coverage check with an 80% line coverage threshold.
- Nightly mutation testing with Infection.
- Runnable examples for merchant, items, inventory, receipts, refunds, webhooks and OAuth.

### Changed

- CI now runs PHPStan on tests and enforces coverage.
- Composer dist archives exclude the new development tooling.

## 4.3.2 - 2026-10-23

### Changed

- Composer dist archives now exclude `.github` and development tooling.
- Removed stale Travis and Scrutinizer entries from `.gitattributes`.
- Removed unused `docs` and legacy PHPUnit cache entries from `.gitignore`.
- Updated the README installation constraint and issue template placeholder to 4.3.

## 4.3.1 - 2026-10-23

### Changed

- Split the monolithic test suite into focused test classes.
- Migrated HTTP and OAuth tests to the `FakesHttpRequests` trait.
- Pint now removes redundant parentheses around `new` expressions via
  `new_expression_parentheses`.

### Removed

- Obsolete `.styleci.yml`; code style is handled by Pint.

## 4.3.0 - 2026-10-23

### Added

- `getRateLimitResetsAt()` on `RateLimitedException`, populated from the
  `x-ratelimit-reset` header.
- `FakesHttpRequests` test trait with real PSR-7 request assertions.
- `EndpointTest` covering every SDK action method.
- `MethodCoverageTest` ensuring every action method has an endpoint test.
- Opt-in integration test suite (`tests/Integration`, `phpunit-integration.xml`).
- `branch-alias` for `dev-master` in `composer.json`.

### Changed

- The default PHPUnit suite excludes integration tests.
- `composer test-integration` runs the opt-in integration suite.

## 4.2.0 - 2026-10-23

### Added

- Configurable base URI, headers and connection timeout.
- `User-Agent` header with the SDK and PHP versions.
- `TokenStore` and `ArrayTokenStore` for OAuth tokens.
- Automatic OAuth token refresh before requests and after `401` responses.
- `Loyverse::fake()` for testing integrations without HTTP calls.
- Enums for webhook events, receipt types, tax types, discount types, payment types,
  item forms, item colors and cash movement types.
- Transport exceptions: `ConnectionException`, `HttpTimeoutException`, `TlsException`.
- `LoyverseException` as the common SDK exception base.
- OpenAPI snapshot and contract test.
- Scheduled workflow that detects changes in the Loyverse OpenAPI specification.
- `SECURITY.md`, issue templates, pull request template and Dependabot configuration.

### Changed

- `composer.json` now exposes issue and source links in the `support` section.
- CI runs `composer audit` in addition to tests, PHPStan and Pint.

## 4.1.1 - 2026-10-23

### Changed

- Normalized PHPDoc alignment with single spacing using Pint's `phpdoc_align` rule.

## 4.1.0 - 2026-10-23

### Changed

- Removed redundant class, trait and enum docblocks that only repeated the symbol name.
- `AccessToken` is now declared as a `readonly` class.
- Pint now uses the PSR-12 preset with `single_line_empty_body` enabled.

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
