<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

use Pashkevich\Loyverse\Loyverse;

#[\AllowDynamicProperties]
class Resource
{
    /**
     * The resource attributes.
     *
     * @var array<string, mixed>
     */
    public array $attributes;

    /**
     * The Loyverse SDK instance.
     */
    protected ?Loyverse $loyverse;

    /**
     * Resource constructor.
     *
     * @param array<string, mixed> $attributes
     */
    public function __construct(array $attributes, ?Loyverse $loyverse = null)
    {
        $this->attributes = $attributes;
        $this->loyverse = $loyverse;

        $this->fill();
    }

    /**
     * Fill the resource with the array of attributes.
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
     */
    protected function camelCase(string $key): string
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
     * Get the Loyverse client attached to this resource.
     */
    protected function client(): Loyverse
    {
        if ($this->loyverse === null) {
            throw new \LogicException('The Loyverse client is not available on this resource.');
        }

        return $this->loyverse;
    }

    /**
     * Transform a nested collection from the resource attributes.
     *
     * @template T of Resource
     *
     * @param class-string<T> $class
     * @return array<int, T>
     */
    protected function transformNested(string $key, string $class): array
    {
        $collection = $this->attributes[$key] ?? [];

        $items = [];

        if (is_array($collection)) {
            foreach ($collection as $item) {
                if (is_array($item)) {
                    $normalized = [];

                    foreach ($item as $itemKey => $itemValue) {
                        if (is_string($itemKey)) {
                            $normalized[$itemKey] = $itemValue;
                        }
                    }

                    $items[] = $normalized;
                }
            }
        }

        return $this->transformCollection($items, $class);
    }

    /**
     * Transform the items of the collection to the given class.
     *
     * @template T of Resource
     *
     * @param array<int, array<string, mixed>> $collection
     * @param class-string<T> $class
     * @param array<string, mixed> $extraData
     * @return array<int, T>
     */
    protected function transformCollection(array $collection, string $class, array $extraData = []): array
    {
        return array_map(function (array $data) use ($class, $extraData): Resource {
            return new $class($data + $extraData, $this->loyverse);
        }, $collection);
    }
}
