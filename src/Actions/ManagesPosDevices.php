<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\PosDevice;

trait ManagesPosDevices
{
    /**
     * Get a list of pos devices.
     *
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    public function posDevices(array $parameters = []): array
    {
        return $this->getPage('pos_devices', $parameters, 'pos_devices', PosDevice::class);
    }

    /**
     * Get a single pos device.
     */
    public function posDevice(string $posDeviceId): PosDevice
    {
        return $this->getResource("pos_devices/$posDeviceId", PosDevice::class);
    }

    /**
     * Create or update a single pos device.
     *
     * @param  array<string, mixed>  $data
     */
    public function createPosDevice(array $data): PosDevice
    {
        return $this->resource($this->post('pos_devices', $data), PosDevice::class);
    }

    /**
     * Delete a single resource.
     *
     * @return array<string, mixed>
     */
    public function deletePosDevice(string $posDeviceId): array
    {
        return $this->deleteResource("pos_devices/$posDeviceId");
    }
}
