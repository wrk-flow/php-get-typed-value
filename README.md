> Get typed (strict mode) values from an Array / XML with basic validation.

![img](https://img.shields.io/badge/PHPStan-8-blue)
![php](https://img.shields.io/badge/PHP-8.1-B0B3D6)

```bash
composer require wrkflow/php-get-typed-value
```

I've created this project as part of my mission to create `work flow` tools / libraries to make my (and yours) **dev
life easier and more enjoyable**.

Want more tools or want to help? Check [wrk-flow.com](https://wrk-flow.com) or [CONTRIBUTE](CONTRIBUTION.md) (I need
help with the documentation, new features, tests).

## Main features

- 🚀 Retrieve values from Array (JSON) / XML with correct return type
- 🏆 Makes PHPStan / IDE happy due the return types
- 🤹‍ Basic type without additional looping.

```php
$data = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\ArrayData([
    'page' => 1, 
    'items' => [
        ['name' => 'test', 'tags' => null, 'label' => 'yes'],
        ['name' => 'test 2', 'tags' => ['test']],
    ],
]));
$page = $data->getRequiredInt('page'); // Will throw MissingValueForKeyException
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
