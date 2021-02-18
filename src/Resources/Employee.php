<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Employee
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Employee extends Resource
{
    /**
     * The id of the employee.
     *
     * @var string
     */
    public string $id;

    /**
     * The name of the employee.
     *
     * @var string
     */
    public string $name;

    /**
     * The email of the employee.
     *
     * @var string|null
     */
    public ?string $email;

    /**
     * The phone number of the employee.
     *
     * @var string|null
     */
    public ?string $phoneNumber;

    /**
     * The list of store ids where this employee has access.
     *
     * @var array
     */
    public array $stores;

    /**
     * Determine if the employee is owner.
     *
     * @var bool
     */
    public bool $isOwner;

    /**
     * The time when this resource was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The time when this resource was updated.
     *
     * @var string
     */
    public string $updatedAt;

    /**
     * The time when this resource was deleted.
     *
     * @var string|null
     */
    public ?string $deletedAt;
}
