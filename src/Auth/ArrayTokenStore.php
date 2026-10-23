<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Auth;

use Pashkevich\Loyverse\AccessToken;

class ArrayTokenStore implements TokenStore
{
    protected ?AccessToken $token = null;

    public function get(): ?AccessToken
    {
        return $this->token;
    }

    public function set(AccessToken $token): void
    {
        $this->token = $token;
    }

    public function clear(): void
    {
        $this->token = null;
    }
}
