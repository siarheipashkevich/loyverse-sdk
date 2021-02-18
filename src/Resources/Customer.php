<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Customer
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Customer extends Resource
{
    /**
     * The customer id.
     *
     * @var string
     */
    public string $id;

    /**
     * The customer's name.
     *
     * @var string
     */
    public string $name;

    /**
     * The customer's email.
     *
     * @var string
     */
    public string $email;

    /**
     * The customer's phone number.
     *
     * @var string
     */
    public string $phoneNumber;

    /**
     * The customer's address.
     *
     * @var string
     */
    public string $address;

    /**
     * The customer's city, town, or village.
     *
     * @var string
     */
    public string $city;

    /**
     * The customer’s region name. Typically a province, a state, or a prefecture.
     *
     * @var string
     */
    public string $region;

    /**
     * The customer’s postal code, also known as zip, postcode, Eircode, etc.
     *
     * @var string
     */
    public string $postalCode;

    /**
     * The two-letter country code corresponding to the customer's country in ISO 3166-1-alpha-2 format.
     *
     * @var string
     */
    public string $countryCode;

    /**
     * The customer's code.
     *
     * @var string
     */
    public string $customerCode;

    /**
     * The note about the customer.
     *
     * @var string
     */
    public string $note;

    /**
     * The date of the first customer visit.
     *
     * @var string
     */
    public string $firstVisit;

    /**
     * The date of the most recent customer visit.
     *
     * @var string
     */
    public string $lastVisit;

    /**
     * The total number of visits.
     *
     * @var int
     */
    public int $totalVisits;

    /**
     * The total money amount that customer had spent.
     *
     * @var float
     */
    public float $totalSpent;

    /**
     * Actual customer points balance.
     *
     * @var float
     */
    public float $totalPoints;

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

    /**
     * The time when the customer data will be permanently deleted (usually 24 hours after soft deletion).
     *
     * @var string
     */
    public string $permanentDeletionAt;

    /**
     * Update the given customer.
     *
     * @param array $data
     * @return Customer
     */
    public function update(array $data): Customer
    {
        return $this->loyverse->createCustomer(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given customer.
     *
     * @return array
     */
    public function delete(): array
    {
        return $this->loyverse->deleteCustomer($this->id);
    }
}
