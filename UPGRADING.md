# Upgrading

## From 4.5.0 to 4.6.0

Enum case names now follow PER Coding Style 3.1 (PascalCase). Values are unchanged, but
every reference to a case must be renamed:

| Before                           | After                            |
|----------------------------------|----------------------------------|
| `Scope::ITEMS_READ`              | `Scope::ItemsRead`               |
| `Scope::POS_DEVICES_READ`        | `Scope::PosDevicesRead`          |
| `Scope::OPENID`                  | `Scope::OpenId`                  |
| `ReceiptType::SALE`              | `ReceiptType::Sale`              |
| `TaxType::INCLUDED`              | `TaxType::Included`              |
| `DiscountType::FIXED_PERCENT`    | `DiscountType::FixedPercent`     |
| `ItemColor::GREEN`               | `ItemColor::Green`               |
| `ItemForm::SQUARE`               | `ItemForm::Square`               |
| `CashMovementType::PAY_IN`       | `CashMovementType::PayIn`        |
| `PaymentType::CASH`              | `PaymentType::Cash`              |
| `PaymentType::NONINTEGRATEDCARD` | `PaymentType::NonIntegratedCard` |
| `WebhookEvent::ITEMS_UPDATE`     | `WebhookEvent::ItemsUpdate`      |
| `WebhookStatus::ENABLED`         | `WebhookStatus::Enabled`         |

The pattern is mechanical: split the old name on `_`, lowercase the rest of each part and
capitalize the first letter, keeping established brand capitalization (`SumUp`, `PayGate`,
`FirstData`, `MercadoPago`). `values()` and `->value` are unaffected.

## From 4.4.0 to 4.5.0

No breaking changes. New additions:

- `Loyverse::page()` returns an opt-in `Paginator` object.
- DTOs in `Pashkevich\Loyverse\Data` for receipts, refunds, inventory and items.
- Resource hydration now skips `null` for non-nullable properties and coerces scalar values
  to the declared property type. Unknown fields remain dynamic.

Existing list methods and array payloads keep working.

## From 4.3.2 to 4.4.0

No breaking changes. This release adds test coverage enforcement, mutation testing, PHPStan
analysis for tests and runnable examples.

## From 4.3.1 to 4.3.2

No breaking changes. This patch only cleans up packaging and stale config references.

## From 4.3.0 to 4.3.1

No breaking changes. This patch only refactors the test suite and Pint configuration.

## From 4.2 to 4.3

No breaking changes. New additions:

- `RateLimitedException::getRateLimitResetsAt()` reads `x-ratelimit-reset`.
- `FakesHttpRequests` test trait.
- `EndpointTest` and `MethodCoverageTest`.
- Opt-in integration tests (`composer test-integration`).
- `dev-master` branch alias.

## From 4.1 to 4.2

No breaking changes. New features:

- `setBaseUri()`, `setHeader()`, `setHeaders()`, `setConnectTimeout()`.
- `withOAuth()`, `setAccessToken()`, `getAccessToken()`, `refreshAccessToken()`.
- `Pashkevich\Loyverse\Auth\TokenStore` and `ArrayTokenStore`.
- `Loyverse::fake()` for tests.
- Enums in `Pashkevich\Loyverse\Enums`.
- Transport exceptions: `ConnectionException`, `HttpTimeoutException`, `TlsException`.

## From 3.x to 4.0

### Requirements

- PHP **8.4** or newer is required.
- Guzzle **8** is required; Guzzle 7 is no longer supported.
- The package now uses `declare(strict_types=1)` internally.

### Scopes

The `Scopes` class has been replaced by the `Scope` enum:

Before:

``` php
use Pashkevich\Loyverse\Scopes;

$scopes = [Scopes::ITEMS_READ, Scopes::RECEIPTS_READ];
```

After:

``` php
use Pashkevich\Loyverse\Scope;

$scopes = [Scope::ItemsRead, Scope::ReceiptsRead];
```

Since 4.6.0 the enum cases use PascalCase; see the 4.5.0 → 4.6.0 section above.

`authorizationUrl()` also accepts plain strings.

### AccessToken

`AccessToken` is now `final` and uses promoted readonly properties. Use
`AccessToken::fromArray()` when building it from an API response:

``` php
$token = AccessToken::fromArray($response);
```

Or pass the values directly:

``` php
$token = new AccessToken(
    'access-token',
    'Bearer',
    43200,
    'refresh-token',
    'ITEMS_READ',
    null,
    time(),
);
```

### Deprecated retry helper

`retry()` is deprecated. Use `retryOnRateLimit()` for rate limited requests.

### Tooling

- PHPUnit 13 is used for development.
- PHPStan runs at level 8.
- Pint is used for code style.

## From 2.x to 3.0

### List methods return pages

All list methods now return the same page structure:

``` php
[
    'items' => [/* resource objects */],
    'cursor' => 'next-page-cursor', // or null
]
```

Before:

``` php
$items = $loyverse->items();
$categories = $loyverse->categories();
```

After:

``` php
$page = $loyverse->items();
$items = $page['items'];
$cursor = $page['cursor'];

$page = $loyverse->categories();
$categories = $page['categories'];
```

The following methods were changed:

- `categories()`
- `customers()`
- `discounts()`
- `modifiers()`
- `paymentTypes()`
- `posDevices()`
- `stores()`
- `suppliers()`
- `taxes()`
- `webhooks()`

The methods that already returned a page array keep the same structure:

- `employees()`
- `items()`
- `receipts()`
- `shifts()`
- `variants()`

### Inventory

`inventory()` now returns a page array instead of an `Inventory` object:

Before:

``` php
$inventory = $loyverse->inventory();
$levels = $inventory->inventoryLevels;
```

After:

``` php
$page = $loyverse->inventory();
$levels = $page['inventory_levels'];
$cursor = $page['cursor'];
```

`updateInventory()` still returns an `Inventory` object.

### Receipt nested objects

Receipt nested arrays are now hydrated into resource objects:

Before:

``` php
$receipt->lineItems[0]['item_name'];
$receipt->lineItems[0]['line_taxes'][0]['rate'];
$receipt->totalDiscounts[0]['money_amount'];
```

After:

``` php
$receipt->lineItems[0]->itemName;
$receipt->lineItems[0]->lineTaxes[0]->rate;
$receipt->totalDiscounts[0]->moneyAmount;
```

New classes:

- `ReceiptLineItem`
- `ReceiptLineTax`
- `ReceiptLineDiscount`
- `ReceiptLineModifier`
- `ReceiptTotalDiscount`
- `ReceiptTotalTax`
- `ReceiptPayment`

### Item components

`Item::$components` is now an array of `ItemComponent` objects:

Before:

``` php
$item->components[0]['variant_id'];
```

After:

``` php
$item->components[0]->variantId;
```

### Property types

- `Receipt::$tip` and `Receipt::$surcharge` are now `float`.
- `Shift::$closedAt`, `Shift::$closedByEmployee` and `Shift::$actualCash` are nullable.
- `Store::$state` and `Store::$country` are nullable.

### New features

- `Loyverse::paginate()` for automatic pagination.
- `Loyverse::retryOnRateLimit()` for retrying rate limited requests.
- `OAuth`, `AccessToken` and `Scopes` for OAuth 2.0 / OpenID Connect.
- `WebhookSignature` for validating `X-Loyverse-Signature`.

### Requirements

- Guzzle 7 and Guzzle 8 are both supported.
- The `ext-hash` extension is now required for webhook signature verification.
