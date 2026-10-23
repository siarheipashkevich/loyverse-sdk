<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Webhook;

/**
 * Trait ManagesWebhooks
 */
trait ManagesWebhooks
{
    /**
     * Get a list of webhooks.
     *
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    public function webhooks(array $parameters = []): array
    {
        return $this->getPage('webhooks', $parameters, 'webhooks', Webhook::class);
    }

    /**
     * Get a single webhook.
     */
    public function webhook(string $webhookId): Webhook
    {
        return $this->getResource("webhooks/$webhookId", Webhook::class);
    }

    /**
     * Create or update a single webhook.
     *
     * @param  array<string, mixed>  $data
     */
    public function createWebhook(array $data): Webhook
    {
        return $this->resource($this->post('webhooks', $data), Webhook::class);
    }

    /**
     * Delete a single resource.
     *
     * @return array<string, mixed>
     */
    public function deleteWebhook(string $webhookId): array
    {
        return $this->deleteResource("webhooks/$webhookId");
    }
}
