# How to Run This Project

## Prerequisites
- PHP 7.4 or higher (You have PHP 8.2.12 ✓)
- Composer (Now installed ✓)

## Setup Instructions

### 1. Install Dependencies
The dependencies are already installed, but if you need to reinstall them:
```bash
php composer.phar install
```

### 2. Run Tests
To verify everything is working correctly:
```bash
php composer.phar test
```

### 3. Use the SDK in Your Project

#### Option A: Run the Example File
1. Get your Loyverse API token from https://loyverse.com
2. Edit `example.php` and replace `YOUR_API_TOKEN_HERE` with your actual token
3. Run the example:
```bash
php example.php
```

#### Option B: Use in Your Own PHP Project
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Pashkevich\Loyverse\Loyverse;

$loyverse = new Loyverse('YOUR_API_TOKEN_HERE');

// Get all categories
$categories = $loyverse->categories();

// Get all items
$items = $loyverse->items();

// Create a new category
$category = $loyverse->createCategory([
    'name' => 'Fruits',
    'color' => 'ORANGE',
]);
```

## Available Commands

- `php composer.phar install` - Install dependencies
- `php composer.phar test` - Run tests
- `php composer.phar test-coverage` - Run tests with coverage report
- `php example.php` - Run the example file (after adding your API token)

## Project Status
✅ Dependencies installed
✅ All tests passing (16 tests, 17 assertions)
✅ Ready to use!

## Documentation
For full API documentation, see the main [README.md](README.md) file.
