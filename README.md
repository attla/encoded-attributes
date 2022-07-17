# Encoded Attributes for eloquent

<p align="center">
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-lightgrey.svg" alt="License"></a>
<a href="https://packagist.org/packages/attla/encoded-attributes"><img src="https://img.shields.io/packagist/v/attla/encoded-attributes" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/attla/encoded-attributes"><img src="https://img.shields.io/packagist/dt/attla/encoded-attributes" alt="Total Downloads"></a>
</p>

🔣 A powerful layer to encode eloquent attributes.

## Installation

```bash
composer require attla/encoded-attributes
```

## Usage

Add the `Attla\EncodedAttributes\HasEncodedAttributes` trait to your model.

To automatically turn some attribute into an encoded attribute, set the following variable for your model.

```php

// getting existed attribute
$model->email

// turning an attribute into an encoded attribute
$model->emailEncoded
// or
$model->email_encoded

```

If you need validate a encoded attribute with rules: `exists`, `unique` use the suffix `_encoded`.

## License

This package is licensed under the [MIT license](LICENSE) © [Octha](https://octha.com).
