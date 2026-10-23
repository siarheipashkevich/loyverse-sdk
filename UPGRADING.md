# Upgrading from 2.x to 3.0

## List methods return pages

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

## Inventory

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

## Receipt nested objects

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

## Item components

`Item::$components` is now an array of `ItemComponent` objects:

Before:

``` php
$item->components[0]['variant_id'];
```

After:

``` php
$item->components[0]->variantId;
```

## Property types

- `Receipt::$tip` and `Receipt::$surcharge` are now `float`.
- `Shift::$closedAt`, `Shift::$closedByEmployee` and `Shift::$actualCash` are nullable.
- `Store::$state` and `Store::$country` are nullable.

## New features

- `Loyverse::paginate()` for automatic pagination.
- `Loyverse::retryOnRateLimit()` for retrying rate limited requests.
- `OAuth`, `AccessToken` and `Scopes` for OAuth 2.0 / OpenID Connect.
- `WebhookSignature` for validating `X-Loyverse-Signature`.

## Requirements

- Guzzle 7 and Guzzle 8 are both supported.
- The `ext-hash` extension is now required for webhook signature verification.
