<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Merchant;

trait ManagesMerchants
{
    /**
     * Get merchant information.
     */
    public function merchant(): Merchant
    {
        return $this->getResource('merchant', Merchant::class);
    }
}
