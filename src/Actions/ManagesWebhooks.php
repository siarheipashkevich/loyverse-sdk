<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Webhook;

/**
 * Trait ManagesWebhooks
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesWebhooks
{
    /**
     * Get a list of webhooks.
     *
     * @param array $parameters
     * @return Webhook[]
     */
    public function webhooks(array $parameters = []): array
    {
        return $this->transformCollection($this->get('webhooks', $parameters)['webhooks'], Webhook::class);
    }

    /**
     * Get a single webhook.
     *
     * @param string $webhookId
     * @return Webhook
     */
    public function webhook(string $webhookId): Webhook
    {
        return new Webhook($this->get("webhooks/$webhookId"), $this);
    }

    /**
     * Create or update a single webhook.
     *
     * @param array $data
     * @return Webhook
     */
    public function createWebhook(array $data): Webhook
    {
        $item = $this->post('webhooks', $data);

        return new Webhook($item, $this);
    }

    /**
     * Delete a single resource.
     *
     * @param string $webhookId
     * @return array
     */
    public function deleteWebhook(string $webhookId): array
    {
        return $this->delete("webhooks/$webhookId");
    }
}
