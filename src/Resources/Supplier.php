<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Supplier
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Supplier extends Resource
{
    /**
     * The supplier id.
     *
     * @var string
     */
    public string $id;

    /**
     * The supplier company name.
     *
     * @var string
     */
    public string $name;

    /**
     * The supplier contact person name.
     *
     * @var string|null
     */
    public ?string $contact;

    /**
     * The supplier email.
     *
     * @var string|null
     */
    public ?string $email;

    /**
     * The supplier phone number.
     *
     * @var string|null
     */
    public ?string $phoneNumber;

    /**
     * The supplier website page.
     *
     * @var string|null
     */
    public ?string $website;

    /**
     * The supplier address.
     *
     * @var string|null
     */
    public ?string $address1;

    /**
     * The supplier address.
     *
     * @var string|null
     */
    public ?string $address2;

    /**
     * The supplier city, town, or village.
     *
     * @var string|null
     */
    public ?string $city;

    /**
     * The supplier’s region name. Typically a province, a state, or a prefecture..
     *
     * @var string|null
     */
    public ?string $region;

    /**
     * The supplier’s postal code, also known as zip, postcode, Eircode, etc.
     *
     * @var string|null
     */
    public ?string $postalCode;

    /**
     * The two-letter country code corresponding to the supplier country in ISO 3166-1-alpha-2 format.
     *
     * @var string|null
     */
    public ?string $countryCode;

    /**
     * The note about the customer.
     *
     * @var string|null
     */
    public ?string $note;

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
     * Update the given supplier.
     *
     * @param array $data
     * @return Supplier
     */
    public function update(array $data): Supplier
    {
        return $this->loyverse->createSupplier(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given supplier.
     *
     * @return array
     */
    public function delete(): array
    {
        return $this->loyverse->deleteSupplier($this->id);
    }
}
