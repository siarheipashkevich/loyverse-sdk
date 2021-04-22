# Loyverse SDK

<a href="https://github.com/siarheipashkevich/loyverse-sdk/actions"><img src="https://github.com/siarheipashkevich/loyverse-sdk/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/pashkevich/loyverse-sdk"><img src="https://img.shields.io/packagist/dt/pashkevich/loyverse-sdk" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/pashkevich/loyverse-sdk"><img src="https://img.shields.io/packagist/v/pashkevich/loyverse-sdk" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/pashkevich/loyverse-sdk"><img src="https://img.shields.io/packagist/l/pashkevich/loyverse-sdk" alt="License"></a>

To work with this package, firstly you **must** have a [Loyverse](https://loyverse.com) account, and secondly you must
create an API token through [Loyverse](https://loyverse.com) itself.

- [Documentation](#documentation)
    - [Installation](#installation)
    - [Basic Usage](#basic-usage)
    - [Managing Categories](#managing-categories)
    - [Managing Customers](#managing-customers)
    - [Managing Discounts](#managing-discounts)
    - [Managing Employees](#managing-employees)
    - [Managing Inventory](#managing-inventory)
    - [Managing Items](#managing-items)
    - [Managing Merchants](#managing-merchants)
    - [Managing Modifiers](#managing-modifiers)
    - [Managing Payment Types](#managing-payment-types)
    - [Managing Pos Devices](#managing-pos-devices)
    - [Managing Receipts](#managing-receipts)
    - [Managing Shifts](#managing-shifts)
    - [Managing Stores](#managing-stores)
    - [Managing Suppliers](#managing-suppliers)
    - [Managing Taxes](#managing-taxes)
    - [Managing Variants](#managing-variants)
    - [Managing Webhooks](#managing-webhooks)
- [Testing](#testing)
- [Contributing](#contributing)
- [Security Vulnerabilities](#security)
- [Credits](#credits)
- [License](#license)

## Documentation

### Installation

To install the SDK in your project you need to require the package via composer:

```bash
composer require pashkevich/loyverse-sdk
```

### Basic Usage

You can create an instance of the SDK like so:

``` php
$loyverse = new Pashkevich\Loyverse\Loyverse(PERSONAL_ACCESS_TOKEN_HERE);
```

Using the `Loyverse` instance you may perform multiple actions as well as retrieve the different resources Loyverse's
API provides:

``` php
$categories = $loyverse->categories();
```

This will give you an array of categories that you have access to, where each category is represented by an instance
of `Pashkevich\Loyverse\Resources\Category`, this instance has multiple public properties like `$id`, `$name`, `$color`
, and others.

You may also retrieve a single category using:

``` php
$category = $loyverse->category(CATEGORY_ID_HERE);
```

On multiple actions supported by this SDK you may need to pass some parameters, for example when creating a new
category:

``` php
$category = $loyverse->createCategory([
    'name' => 'Fruits',
    'color' => 'ORANGE',
]);
```

These parameters will be used in the POST request sent to Loyverse servers, you can find more information about the
parameters needed for each action on
[Loyverse's official API documentation](https://developer.loyverse.com/docs).

You can also set the desired timeout value:

``` php
$loyverse->setTimeout(120)->createCategory(array $data);
```

### Managing Categories

``` php
$loyverse->categories(array $parameters);
$loyverse->category(string $categoryId);
$loyverse->createCategory(array $data);
$loyverse->deleteCategory(string $categoryId);
```

On a `Category` instance you may also call:

``` php
$category->update(array $data);
$category->delete();
```

### Managing Customers

``` php
$loyverse->customers(array $parameters);
$loyverse->customer(string $customerId);
$loyverse->createCustomer(array $data);
$loyverse->deleteCustomer(string $customerId);
```

On a `Customer` instance you may also call:

``` php
$customer->update(array $data);
$customer->delete();
```

### Managing Discounts

``` php
$loyverse->discounts(array $parameters);
$loyverse->discount(string $discountId);
$loyverse->createDiscount(array $data);
$loyverse->deleteDiscount(string $discountId);
```

On a `Discount` instance you may also call:

``` php
$discount->update(array $data);
$discount->delete();
```

### Managing Employees

``` php
$loyverse->employees(array $parameters);
$loyverse->employee(string $employeeId);
```

### Managing Inventory

``` php
$loyverse->inventory(array $parameters);
$loyverse->updateInventory(array $data);
```

### Managing Items

``` php
$loyverse->items(array $parameters);
$loyverse->item(string $itemId);
$loyverse->createItem(array $data);
$loyverse->deleteItem(string $itemId);
```

On a `Item` instance you may also call:

``` php
$item->update(array $data);
$item->delete();
```

### Managing Merchants

``` php
$loyverse->merchant();
```

### Managing Modifiers

``` php
$loyverse->modifiers(array $parameters);
$loyverse->modifier(string $modifierId);
$loyverse->createModifier(array $data);
$loyverse->deleteModifier(string $modifierId);
```

On a `Modifier` instance you may also call:

``` php
$modifier->update(array $data);
$modifier->delete();
```

### Managing Payment Types

``` php
$loyverse->paymentTypes(array $parameters);
$loyverse->paymentType(string $paymentTypeId);
```

### Managing Pos Devices

``` php
$loyverse->posDevices(array $parameters);
$loyverse->posDevice(string $posDeviceId);
$loyverse->createPosDevice(array $data);
$loyverse->deletePosDevice(string $posDeviceId);
```

On a `PosDevice` instance you may also call:

``` php
$posDevice->update(array $data);
$posDevice->delete();
```

### Managing Receipts

``` php
$loyverse->receipts(array $parameters);
$loyverse->receipt(string $receiptNumber);
$loyverse->createReceipt(array $data);
$loyverse->createReceiptRefund(string $receiptNumber, array $data);
```

On a `Receipt` instance you may also call:

``` php
$receipt->refund(array $data);
```

### Managing Shifts

``` php
$loyverse->shifts(array $parameters);
$loyverse->shift(string $shiftId);
```

### Managing Stores

``` php
$loyverse->stores(array $parameters);
$loyverse->store(string $storeId);
```

### Managing Suppliers

``` php
$loyverse->suppliers(array $parameters);
$loyverse->supplier(string $supplierId);
$loyverse->createSupplier(array $data);
$loyverse->deleteSupplier(string $supplierId);
```

On a `Supplier` instance you may also call:

``` php
$supplier->update(array $data);
$supplier->delete();
```

### Managing Taxes

``` php
$loyverse->taxes(array $parameters);
$loyverse->tax(string $taxId);
$loyverse->createTax(array $data);
$loyverse->deleteTax(string $taxId);
```

On a `Tax` instance you may also call:

``` php
$tax->update(array $data);
$tax->delete();
```

### Managing Variants

``` php
$loyverse->variants(array $parameters);
$loyverse->variant(string $variantId);
$loyverse->createVariant(array $data);
$loyverse->deleteVariant(string $variantId);
```

On a `Variant` instance you may also call:

``` php
$variant->update(array $data);
$variant->delete();
```

### Managing Webhooks

``` php
$loyverse->webhooks(array $parameters);
$loyverse->webhook(string $webhookId);
$loyverse->createWebhook(array $data);
$loyverse->deleteWebhook(string $webhookId);
```

On a `Webhook` instance you may also call:

``` php
$webhook->update(array $data);
$webhook->delete();
```

### Testing

``` bash
composer test
```

### Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email siarheipashkveich@gmail.com instead of using the issue
tracker.

### Credits

- [Sergey Pashkevich](https://github.com/siarheipashkevich)

## License

Loyverse SDK is open-sourced software licensed under the [MIT license](LICENSE.md).
