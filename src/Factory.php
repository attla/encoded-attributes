<?php

namespace Attla\EncodedAttributes;

use Attla\DataToken\Facade as DataToken;
use Illuminate\Database\Eloquent\Model;

class Factory
{
    /**
     * Get a encoded ID
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return string|null
     */
    public static function encodedId(Model $model)
    {
        $key = $model->getKeyName();
        return !empty($model->{$key}) ? DataToken::id($model->{$key}) : null;
    }

    /**
     * Get a encoded attribute
     *
     * @param mixed $attribute
     * @return mixed
     */
    public static function encode($attribute)
    {
        return $attribute ? DataToken::id($attribute) : $attribute;
    }

    /**
     * Check if value is a encoded attribute and resolve it
     *
     * @param mixed $value
     * @return mixed
     */
    public static function resolve($value)
    {
        if (is_array($value)) {
            return array_map([get_called_class(), 'resolver'], $value);
        }

        if (is_string($value) and $encodedId = \DataToken::decode($value)) {
            return $encodedId;
        }

        return $value;
    }
}
