<?php

declare(strict_types=1);

use Pashkevich\Loyverse\WebhookSignature;

require __DIR__.'/../vendor/autoload.php';

$secret = getenv('LOYVERSE_CLIENT_SECRET');
$payload = file_get_contents('php://input') ?: '';
$signature = $_SERVER['HTTP_X_LOYVERSE_SIGNATURE'] ?? '';

if ($secret === false || $secret === '' || ! WebhookSignature::verify($payload, $signature, $secret)) {
    http_response_code(401);
    exit;
}

$event = json_decode($payload, true);

if (is_array($event)) {
    error_log('Loyverse webhook: '.($event['type'] ?? 'unknown'));
}

http_response_code(204);
