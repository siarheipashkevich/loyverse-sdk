<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

class PosDevice extends Resource
{
    /**
     * The pos device id.
     */
    public string $id;

    /**
     * The name of the pos device.
     */
    public string $name;

    /**
     * The store id this device is connected to.
     */
    public string $storeId;

    /**
     * Shows the status of the POS device. If true, this device is connected to the physical device.
     */
    public bool $activated;

    /**
     * The time when this resource was deleted.
     */
    public ?string $deletedAt;

    /**
     * Update the given pos device.
     *
     * @param array<string, mixed> $data
     */
    public function update(array $data): PosDevice
    {
        return $this->client()->createPosDevice(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given pos device.
     *
     * @return array<string, mixed>
     */
    public function delete(): array
    {
        return $this->client()->deletePosDevice($this->id);
    }
}
