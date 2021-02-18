# Loyverse SDK

<a href="https://github.com/siarheipashkevich/loyverse-sdk/actions"><img src="https://github.com/siarheipashkevich/loyverse-sdk/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/pashkevich/loyverse-sdk"><img src="https://img.shields.io/packagist/dt/pashkevich/loyverse-sdk" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/pashkevich/loyverse-sdk"><img src="https://img.shields.io/packagist/v/pashkevich/loyverse-sdk" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/pashkevich/loyverse-sdk"><img src="https://img.shields.io/packagist/l/pashkevich/loyverse-sdk" alt="License"></a>

A simple to use PHP class to work with the Loyverse API.

## Installation

To install the SDK in your project you need to require the package via composer:

```bash
composer require pashkevich/loyverse-sdk
```

To work with this package, firstly you **must** have a [Loyverse](https://loyverse.com/) account, and secondly you must
create an API token through [Loyverse](https://loyverse.com/) itself.

### Basic Usage

You can create an instance of the SDK like so:

``` php
$loyverse = new Pashkevich\Loyverse\Loyverse(PERSONAL_ACCESS_TOKEN_HERE);
```

Using the `Loyverse` instance you may perform multiple actions as well as retrieve the different resources Loyverse's
API provides:

``` php
$employees = $loyverse->employees();
```

This will give you an array of employees that you have access to, where each employee is represented by an instance
of `Pashkevich\Loyverse\Resources\Employee`, this instance has multiple public properties like `$id`, `$name`, `$email`
, `$phoneNumber`, and others.

You may also retrieve a single employee using:

``` php
$employee = $loyverse->employee(EMPLOYEE_ID_HERE);
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

### Managing Inventory

``` php
$loyverse->inventory(array $parameters);
$loyverse->updateInventory(array $data);
```

### Managing Shifts

``` php
$loyverse->shifts(array $parameters);
$loyverse->shift(string $shiftId);
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

### Managing Payment Types

``` php
$loyverse->paymentTypes(array $parameters);
$loyverse->paymentType(string $paymentTypeId);
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email siarheipashkveich@gmail.com instead of using the issue
tracker.

## Credits

- [Sergey Pashkevich](https://github.com/siarheipashkevich)

## License

Loyverse SDK is open-sourced software licensed under the [MIT license](LICENSE.md).
