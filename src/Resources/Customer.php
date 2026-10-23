<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Customer
 */
class Customer extends Resource
{
    /**
     * The customer id.
     */
    public string $id;

    /**
     * The customer's name.
     */
    public string $name;

    /**
     * The customer's email.
     */
    public ?string $email;

    /**
     * The customer's phone number.
     */
    public ?string $phoneNumber;

    /**
     * The customer's address.
     */
    public ?string $address;

    /**
     * The customer's city, town, or village.
     */
    public ?string $city;

    /**
     * The customer’s region name. Typically a province, a state, or a prefecture.
     */
    public ?string $region;

    /**
     * The customer’s postal code, also known as zip, postcode, Eircode, etc.
     */
    public ?string $postalCode;

    /**
     * The two-letter country code corresponding to the customer's country in ISO 3166-1-alpha-2 format.
     */
    public ?string $countryCode;

    /**
     * The customer's code.
     */
    public ?string $customerCode;

    /**
     * The note about the customer.
     */
    public ?string $note;

    /**
     * The date of the first customer visit.
     */
    public ?string $firstVisit;

    /**
     * The date of the most recent customer visit.
     */
    public ?string $lastVisit;

    /**
     * The total number of visits.
     */
    public int $totalVisits;

    /**
     * The total money amount that customer had spent.
     */
    public float $totalSpent;

    /**
     * Actual customer points balance.
     */
    public float $totalPoints;

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

    /**
     * The time when the customer data will be permanently deleted (usually 24 hours after soft deletion).
     */
    public ?string $permanentDeletionAt;

    /**
     * Update the given customer.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(array $data): Customer
    {
        return $this->client()->createCustomer(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given customer.
     *
     * @return array<string, mixed>
     */
    public function delete(): array
    {
        return $this->client()->deleteCustomer($this->id);
    }
}
