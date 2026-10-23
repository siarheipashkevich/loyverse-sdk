<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Webhook
 */
class Webhook extends Resource
{
    /**
     * The webhook id.
     */
    public string $id;

    /**
     * The id of the merchant which the webhook request originates from.
     */
    public string $merchantId;

    /**
     * URI where the webhook should send the POST request when the event occurs.
     */
    public string $url;

    /**
     * The webhook type.
     */
    public string $type;

    /**
     * The current status of webhook.
     */
    public string $status;

    /**
     * The time when of the webhook was created.
     */
    public string $createdAt;

    /**
     * The time when of the webhook was updated.
     */
    public string $updatedAt;

    /**
     * The time when this resource was deleted.
     */
    public ?string $deletedAt;

    /**
     * Update the given webhook.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(array $data): Webhook
    {
        return $this->client()->createWebhook(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given webhook.
     *
     * @return array<string, mixed>
     */
    public function delete(): array
    {
        return $this->client()->deleteWebhook($this->id);
    }
}
