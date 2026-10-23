# Security Policy

## Supported Versions

| Version | Supported |
|---------|-----------|
| 4.x     | ✅         |
| 3.x     | ❌         |
| < 3.0   | ❌         |

## Reporting a Vulnerability

Please do **not** open a public issue for security vulnerabilities.

Send a report to **siarheipashkevich@gmail.com** with:

- the affected SDK version;
- a description of the issue;
- reproduction steps or a proof of concept;
- any suggested fix.

You should receive a response within 72 hours. Once the issue is confirmed, a fix and a
security release will be prepared as soon as possible.

## Handling Access Tokens

- Never commit personal access tokens, OAuth client secrets or refresh tokens.
- Prefer environment variables or a secret manager.
- The SDK marks token and secret parameters with `#[\SensitiveParameter]`, but you are
  responsible for not logging request payloads that contain credentials.
- If a token leaks, revoke it in the Loyverse back office and issue a new one.

## Webhooks

Webhooks created by OAuth2 applications include an `X-Loyverse-Signature` header. Always
verify it against the raw request body before processing the payload:

``` php
use Pashkevich\Loyverse\WebhookSignature;

$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_LOYVERSE_SIGNATURE'] ?? '';

if (! WebhookSignature::verify($payload, $signature, CLIENT_SECRET)) {
    http_response_code(401);
    exit;
}
```

## Dependencies

Dependency updates are monitored with Dependabot and `composer audit`.
