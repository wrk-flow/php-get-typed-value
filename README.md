# php-get-typed-value

![img](https://img.shields.io/badge/PHPStan-8-blue)
![php](https://img.shields.io/badge/PHP-8.1-B0B3D6)
![coverage](https://img.shields.io/endpoint?url=https://gist.githubusercontent.com/pionl/11b884c06da0bf9116ae763d23438ecb/raw/coverage.json)

Get typed (strict mode) values from an Array / XML with basic validation.

```bash
composer require wrkflow/php-get-typed-value
```

## Main features

- 🚀 Retrieve values from Array (JSON) / XML with correct return type with **safe dot notation** support.
- 🏆 **Makes PHPStan / IDE** happy due the type strict return types.
- 🤹‍ **Validation:** Ensures that desired value is in correct type (without additional loop validation).
- 🛠 **Transformers:** Ensures that values are in expected type.
- ⛑ Converts empty string values to null (can be disabled, see transformers).

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;

$data = new GetValue(new ArrayData([
    'address' => [
        'street' => [
            'number' => '13',
        ],
        'name' => '',
    ]   
]));
$data->getInt('address.street.number') // Returns: 13 (int)
$data->getString('address.street.name') // Returns: null because value does not exists
$data->getRequiredString('address.street.name') // Returns: throws MissingValueForKeyException exception
```

## Documentation

Documentation is hosted on [GitHub Pages](https://php-get-typed-value.wrk-flow.com).

## Comment

I've created this project as part of my mission to create `work flow` tools / libraries to make my (and yours) **dev
life easier and more enjoyable**.

Want more tools or want to help? Check [wrk-flow.com](https://wrk-flow.com) or [CONTRIBUTE](CONTRIBUTION.md). You can
help me improve the documentation, add new tests and features. Are you junior developer? Don't be scared, get in touch
and I will guide you in your first contribution.
