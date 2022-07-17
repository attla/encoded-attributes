<?php

namespace Attla\EncodedAttributes;

use Illuminate\Support\{
    Enumerable,
    Str,
};
use Illuminate\Contracts\Support\{
    Arrayable,
    Jsonable,
};

trait HasEncodedAttributes
{
    /**
     * Create a new Eloquent model instance
     *
     * @param array|object $attributes
     * @return void
     */
    public function __construct($attributes = [])
    {
        if ($attributes instanceof Enumerable) {
            $attributes = $attributes->all();
        } elseif ($attributes instanceof Arrayable) {
            $attributes = $attributes->toArray();
        } elseif ($attributes instanceof Jsonable) {
            $attributes = json_decode($attributes->toJson(), true);
        } elseif ($attributes instanceof \JsonSerializable) {
            $attributes = (array) $attributes->jsonSerialize();
        } elseif ($attributes instanceof \Traversable) {
            $attributes = iterator_to_array($attributes);
        } elseif (!is_array($attributes)) {
            $attributes = (array) $attributes;
        }

        parent::__construct($attributes);
    }

    /**
     * Get a encoded id
     *
     * @return string
     */
    public function getEncodedIdAttribute()
    {
        return Factory::encodedId($this);
    }

    /**
     * Create a new Eloquent query builder for the model
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    /**
     * Get an attribute from the model
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        $originalKey = $key;

        if ($isEncoded = Str::endsWith($key, $suffixes = ['Encoded', '_encoded'])) {
            $key .= $id = '#42';

            array_map(function ($suffix) use (&$key, $id) {
                $key = str_replace($suffix . $id, '', $key);
            }, $suffixes);

            $key = str_replace($id, '', $key);
        }

        $value = parent::getAttribute($key);

        return $isEncoded
            ? (Factory::encode($value) ?: parent::getAttribute($originalKey))
            : $value;
    }

    /**
     * Set a given attribute on the model
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        return parent::setAttribute($key, Factory::resolve($value));
    }

    /**
     * Retrieve the model for a bound value
     *
     * @param mixed $value
     * @param string|null $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return parent::resolveRouteBinding(Factory::resolve($value), $field);
    }

   /**
     * Retrieve the model for a bound value
     *
     * @param mixed $value
     * @param string|null $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveSoftDeletableRouteBinding($value, $field = null)
    {
        return parent::resolveSoftDeletableRouteBinding(Factory::resolve($value), $field);
    }

    /**
     * Retrieve the child model for a bound value
     *
     * @param string $childType
     * @param mixed $value
     * @param string|null $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveChildRouteBinding($childType, $value, $field = null)
    {
        return parent::resolveChildRouteBinding($childType, Factory::resolve($value), $field);
    }

    /**
     * Retrieve the child model for a bound value
     *
     * @param string $childType
     * @param mixed $value
     * @param string|null $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveSoftDeletableChildRouteBinding($childType, $value, $field = null)
    {
        return parent::resolveSoftDeletableChildRouteBinding($childType, Factory::resolve($value), $field);
    }

    /**
     * Retrieve the model for a bound value
     *
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\Relation $query
     * @param mixed $value
     * @param string|null $field
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        return parent::resolveRouteBindingQuery($query, Factory::resolve($value), $field);
    }
}
