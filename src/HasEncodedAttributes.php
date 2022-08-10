<?php

namespace Attla\EncodedAttributes;

use Attla\Support\Arr as AttlaArr;
use Illuminate\Support\Str;

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
        parent::__construct(AttlaArr::toArray($attributes));
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

        array_map(function ($suffix) use (&$key) {
            if (Str::endsWith($key, $suffix)) {
                $key = Str::beforeLast($key, $suffix);
            }
        }, ['Encoded', '_encoded']);

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
