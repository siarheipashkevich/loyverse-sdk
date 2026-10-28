<?php

declare(strict_types=1);

use Pashkevich\Loyverse\OAuth;
use Pashkevich\Loyverse\Scope;

require __DIR__.'/../vendor/autoload.php';

$clientId = getenv('OAUTH_CLIENT_ID');
$clientSecret = getenv('OAUTH_CLIENT_SECRET');
$redirectUri = getenv('OAUTH_REDIRECT_URI');
$code = getenv('OAUTH_CODE');

if ($clientId === false || $clientSecret === false || $redirectUri === false) {
    fwrite(STDERR, "Set OAUTH_CLIENT_ID, OAUTH_CLIENT_SECRET and OAUTH_REDIRECT_URI.\n");
    exit(1);
}

$oauth = new OAuth();
$state = OAuth::generateState();

echo $oauth->authorizationUrl(
    $clientId,
    $redirectUri,
    $state,
    [Scope::ItemsRead, Scope::ReceiptsRead]
).PHP_EOL;

if ($code !== false && $code !== '') {
    $token = $oauth->exchangeCode($clientId, $clientSecret, $code, $redirectUri);

    echo 'Access token: '.$token->accessToken.PHP_EOL;

    if ($token->refreshToken !== null) {
        $refreshed = $oauth->refreshToken($clientId, $clientSecret, $token->refreshToken);
        echo 'Refreshed token: '.$refreshed->accessToken.PHP_EOL;
    }
}
