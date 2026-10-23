<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

class Employee extends Resource
{
    /**
     * The id of the employee.
     */
    public string $id;

    /**
     * The name of the employee.
     */
    public string $name;

    /**
     * The email of the employee.
     */
    public ?string $email;

    /**
     * The phone number of the employee.
     */
    public ?string $phoneNumber;

    /**
     * The list of store ids where this employee has access.
     *
     * @var string[]
     */
    public array $stores;

    /**
     * Determine if the employee is owner.
     */
    public bool $isOwner;

    /**
     * The time when this resource was created.
     */
    public string $createdAt;

    /**
     * The time when this resource was updated.
     */
    public string $updatedAt;

    /**
     * The time when this resource was deleted.
     */
    public ?string $deletedAt;
}
