# Changelog

All notable changes to `loyverse-sdk` will be documented in this file

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
