<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class PosDevice
 *
 * @package Pashkevich\Loyverse\Resources
 */
class PosDevice extends Resource
{
    /**
     * The pos device id.
     *
     * @var string
     */
    public string $id;

    /**
     * The name of the pos device.
     *
     * @var string
     */
    public string $name;

    /**
     * The store id this device is connected to.
     *
     * @var string
     */
    public string $storeId;

    /**
     * Shows the status of the POS device. If true, this device is connected to the physical device.
     *
     * @var bool
     */
    public bool $activated;

    /**
     * The time when this resource was deleted.
     *
     * @var string|null
     */
    public ?string $deletedAt;

    /**
     * Update the given pos device.
     *
     * @param array $data
     * @return PosDevice
     */
    public function update(array $data): PosDevice
    {
        return $this->loyverse->createPosDevice(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given pos device.
     *
     * @return array
     */
    public function delete(): array
    {
        return $this->loyverse->deletePosDevice($this->id);
    }
}
