<?php

namespace Pashkevich\Loyverse\Resources;

use Pashkevich\Loyverse\Loyverse;

/**
 * Class Resource
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Resource
{
    /**
     * The resource attributes.
     *
     * @var array
     */
    public array $attributes;

    /**
     * The Loyverse SDK instance.
     *
     * @var Loyverse|null
     */
    protected ?Loyverse $loyverse;

    /**
     * Resource constructor.
     *
     * @param array $attributes
     * @param Loyverse|null $loyverse
     */
    public function __construct(array $attributes, Loyverse $loyverse = null)
    {
        $this->attributes = $attributes;
        $this->loyverse = $loyverse;

        $this->fill();
    }

    /**
     * Fill the resource with the array of attributes.
     *
     * @return void
     */
    protected function fill(): void
    {
        foreach ($this->attributes as $key => $value) {
            $key = $this->camelCase($key);

            $this->{$key} = $value;
        }
    }

    /**
     * Convert the key name to camel case.
     *
     * @param string $key
     * @return string
     */
    protected function camelCase($key)
    {
        $parts = explode('_', $key);

        foreach ($parts as $i => $part) {
            if ($i !== 0) {
                $parts[$i] = ucfirst($part);
            }
        }

        return str_replace(' ', '', implode(' ', $parts));
    }

    /**
     * Transform the items of the collection to the given class.
     *
     * @param array $collection
     * @param string $class
     * @param array $extraData
     * @return array
     */
    protected function transformCollection(array $collection, string $class, array $extraData = []): array
    {
        return array_map(function ($data) use ($class, $extraData) {
            return new $class($data + $extraData, $this->loyverse);
        }, $collection);
    }
}
