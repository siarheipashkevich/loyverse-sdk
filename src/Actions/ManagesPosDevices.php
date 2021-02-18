<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\PosDevice;

/**
 * Trait ManagesPosDevices
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesPosDevices
{
    /**
     * Get a list of pos devices.
     *
     * @param array $parameters
     * @return PosDevice[]
     */
    public function posDevices(array $parameters = []): array
    {
        return $this->transformCollection($this->get('pos_devices', $parameters)['pos_devices'], PosDevice::class);
    }

    /**
     * Get a single pos device.
     *
     * @param string $posDeviceId
     * @return PosDevice
     */
    public function posDevice(string $posDeviceId): PosDevice
    {
        return new PosDevice($this->get("pos_devices/$posDeviceId"), $this);
    }

    /**
     * Create or update a single pos device.
     *
     * @param array $data
     * @return PosDevice
     */
    public function createPosDevice(array $data): PosDevice
    {
        $item = $this->post('pos_devices', $data);

        return new PosDevice($item, $this);
    }

    /**
     * Delete a single resource.
     *
     * @param string $posDeviceId
     * @return array
     */
    public function deletePosDevice(string $posDeviceId): array
    {
        return $this->delete("pos_devices/$posDeviceId");
    }
}
