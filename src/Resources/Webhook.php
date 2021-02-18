<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Webhook
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Webhook extends Resource
{
    /**
     * The webhook id.
     *
     * @var string
     */
    public string $id;

    /**
     * The id of the merchant which the webhook request originates from.
     *
     * @var string
     */
    public string $merchantId;

    /**
     * URI where the webhook should send the POST request when the event occurs.
     *
     * @var string
     */
    public string $url;

    /**
     * The webhook type.
     *
     * @var string
     */
    public string $type;

    /**
     * The current status of webhook.
     *
     * @var string
     */
    public string $status;

    /**
     * The time when of the webhook was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The time when of the webhook was updated.
     *
     * @var string
     */
    public string $updatedAt;

    /**
     * Update the given webhook.
     *
     * @param array $data
     * @return Webhook
     */
    public function update(array $data): Webhook
    {
        return $this->loyverse->createWebhook(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given webhook.
     *
     * @return array
     */
    public function delete(): array
    {
        return $this->loyverse->deleteWebhook($this->id);
    }
}
