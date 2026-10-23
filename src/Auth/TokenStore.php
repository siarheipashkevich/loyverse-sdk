<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Auth;

use Pashkevich\Loyverse\AccessToken;

interface TokenStore
{
    public function get(): ?AccessToken;

    public function set(AccessToken $token): void;

    public function clear(): void;
}
