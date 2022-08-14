<?php

namespace Attla\EncodedAttributes;

use Attla\DataToken\Facade as DataToken;

class Factory
{
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
            return array_map([get_called_class(), 'resolve'], $value);
        }

        if (is_string($value) and $encodedId = DataToken::decode($value)) {
            return $encodedId;
        }

        return $value;
    }
}
