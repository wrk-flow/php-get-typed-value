# php-get-typed-value

![img](https://img.shields.io/badge/PHPStan-8-blue)
![php](https://img.shields.io/badge/PHP-8.1-B0B3D6)
![coverage](https://img.shields.io/endpoint?url=https://gist.githubusercontent.com/pionl/11b884c06da0bf9116ae763d23438ecb/raw/coverage.json)

Get typed (strict mode) values from an Array / XML with basic validation.

```bash
composer require wrkflow/php-get-typed-value
```

## Main features

- 🚀 Retrieve values from Array (JSON) / XML with correct return type with **dot notation** support.
- 🏆 **Makes PHPStan / IDE** happy due the type strict return types.
- 🤹‍ **Validation:** Ensures that desired value is in correct type (without additional loop validation).
- 🛠 **Transformers:** Ensures that values are in expected type

```php
$data = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\ArrayData([
    'page' => 1, 
    'items' => [
        ['name' => 'test', 'tags' => null, 'label' => 'yes'],
        ['name' => 'test 2', 'tags' => ['test']],
    ],
]));
$page = $data->getRequiredInt('page'); // Will throw MissingValueForKeyException if the `page` is not present
$items = $data->getRequiredArray('items');

foreach ($items as $item) {
    $itemData = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\ArrayData($item));
    
    $name = $itemData->getRequiredString('name');
    // getArray will ensure convert null (not present) values to empty array
    foreach ($itemData->getArray('tags') as $tag) {
        // $tag should be string, validate it
    }
    // Get label will return nullable string
    $label = $itemData->getString('label');
}
```

## Documentation

Documentation is hosted on [GitHub Pages](https://php-get-typed-value.wrk-flow.com).

## Comment

I've created this project as part of my mission to create `work flow` tools / libraries to make my (and yours) **dev
life easier and more enjoyable**.

Want more tools or want to help? Check [wrk-flow.com](https://wrk-flow.com) or [CONTRIBUTE](CONTRIBUTION.md). You can
help me improve the documentation, add new tests and features. Are you junior developer? Don't be scared, get in touch
and I will guide you in your first contribution.
