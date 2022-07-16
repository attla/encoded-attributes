<?php

namespace Attla\EncodedAttributes;

use Illuminate\Support\{
    ServiceProvider as BaseServiceProvider,
    Facades\Validator
};

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend(
            'exists_encoded',
            fn ($attribute, $value, $parameters, $validator) => $validator->validateExists(
                $attribute,
                Factory::resolve($value),
                $parameters
            )
        );

        Validator::extend(
            'unique_encoded',
            fn ($attribute, $value, $parameters, $validator) => $validator->validateUnique(
                $attribute,
                Factory::resolve($value),
                $parameters
            )
        );
    }
}
