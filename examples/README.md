# Loyverse SDK examples

Install dependencies first:

```bash
composer install
```

Set a personal access token:

```bash
export LOYVERSE_API_TOKEN="your-token"
```

Run an example:

```bash
php examples/merchant.php
php examples/items.php
php examples/inventory.php
```

## Receipts

Create a receipt:

```bash
export STORE_ID="..."
export VARIANT_ID="..."
export PAYMENT_TYPE_ID="..."
export AMOUNT="10.00"
php examples/create-receipt.php
```

Create a refund:

```bash
export RECEIPT_NUMBER="1-1001"
export LINE_ITEM_ID="..."
php examples/refund-receipt.php
```

## Webhooks

Point your webhook URL to `examples/webhook.php` (served by your web server) and set:

```bash
export LOYVERSE_CLIENT_SECRET="your-oauth-client-secret"
```

The example reads the raw request body, verifies `X-Loyverse-Signature` and returns `204`.

## OAuth

```bash
export OAUTH_CLIENT_ID="..."
export OAUTH_CLIENT_SECRET="..."
export OAUTH_REDIRECT_URI="https://example.com/callback"
php examples/oauth.php
```

The script prints the authorization URL. After the callback, set `OAUTH_CODE` and run it again to
exchange the code and refresh the token.
