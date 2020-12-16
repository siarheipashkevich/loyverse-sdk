<?php

namespace Esupl\Loyverse\Resources;

/**
 * Class Employee
 *
 * @package Esupl\Loyverse\Resources
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
     * @var string
     */
    public string $email;

    /**
     * The phone number of the employee.
     *
     * @var string
     */
    public string $phoneNumber;

    /**
     * The list of store ids where this employee has access.
     *
     * @var array
     */
    public array $stores = [];

    /**
     * Determine if the employee is owner.
     *
     * @var bool
     */
    public bool $isOwner;

    /**
     * The date/time the resource was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The date/time the resource was updated.
     *
     * @var string
     */
    public string $updatedAt;

    /**
     * The date/time the resource was deleted.
     *
     * @var string
     */
    public string $deletedAt;
}
