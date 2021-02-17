<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Merchant;

/**
 * Trait ManagesMerchants
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesMerchants
{
    /**
     * Get merchant information.
     *
     * @return Merchant
     */
    public function merchant(): Merchant
    {
        return new Merchant($this->get('merchant'), $this);
    }
}
