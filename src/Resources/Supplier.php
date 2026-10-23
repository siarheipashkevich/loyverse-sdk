<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

class Supplier extends Resource
{
    /**
     * The supplier id.
     */
    public string $id;

    /**
     * The supplier company name.
     */
    public string $name;

    /**
     * The supplier contact person name.
     */
    public ?string $contact;

    /**
     * The supplier email.
     */
    public ?string $email;

    /**
     * The supplier phone number.
     */
    public ?string $phoneNumber;

    /**
     * The supplier website page.
     */
    public ?string $website;

    /**
     * The supplier address.
     */
    public ?string $address1;

    /**
     * The supplier address.
     */
    public ?string $address2;

    /**
     * The supplier city, town, or village.
     */
    public ?string $city;

    /**
     * The supplier’s region name. Typically a province, a state, or a prefecture..
     */
    public ?string $region;

    /**
     * The supplier’s postal code, also known as zip, postcode, Eircode, etc.
     */
    public ?string $postalCode;

    /**
     * The two-letter country code corresponding to the supplier country in ISO 3166-1-alpha-2 format.
     */
    public ?string $countryCode;

    /**
     * The note about the customer.
     */
    public ?string $note;

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
     * Update the given supplier.
     *
     * @param array<string, mixed> $data
     */
    public function update(array $data): Supplier
    {
        return $this->client()->createSupplier(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given supplier.
     *
     * @return array<string, mixed>
     */
    public function delete(): array
    {
        return $this->client()->deleteSupplier($this->id);
    }
}
