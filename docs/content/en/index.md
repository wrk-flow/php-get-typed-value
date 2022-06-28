---
title: Introduction
subtitle: 'Get typed (strict mode) values from an Array / XML with basic validation.'
position: 1
---

<img src="https://img.shields.io/badge/PHPStan-8-blue" class="inline-flex" style="margin: 0;" /> 
<img src="https://img.shields.io/badge/PHP-8.1-B0B3D6"  class="inline-flex" style="margin: 0;" />

## Main features

- 🚀 Retrieve values from Array (JSON) / XML with correct return type
- 🏆 Makes PHPStan / IDE happy due the return types
- 🤹‍ Ensures that desired value is in correct type (without additional loop validation. Validates always on get).

## Installation

```bash
composer require wrkflow/php-get-typed-value
```

## Usage

Use of this package is super simple. You need to always create **GetValue** object with desired data format you are
using.

Then you are going to use same methods for any format you choose.

### Use with array

Simple build **GetValue** class with **ArrayData** class that will expose the data.

```php
$data = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\ArrayData([
    'page' => 1, 
    'items' => [
        ['name' => 'test', 'tags' => null, 'label' => 'yes'], 
        ['name' => 'test 2', 'tags' => ['test'],]
    ],
]));
```

### Use with XML

Simple build **GetValue** class with **XMLData** class that will expose the data.

```php
$simpleXMLElement = new SimpleXMLElement('<root><title>test</title><test attribute="test"/></root>');
$data = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\XMLData($simpleXMLElement));
```

## Values

> All values are validated within its type definition (int will be checked by IntegerRule, string by StringRule, etc).

For getting values there are always 2 methods:

- get nullable value
- get required value

You can additionally add validation rules (as second parameter) to ensure you will get correct value.
Check [Validation documentation](/validation) for more.

### Int

> Throws `ValidationFailedException` if value is not numeric (only on non-null values).

Get nullable int.

```php
$value = $data->getInt('key', rules: [new \Wrkflow\GetValue\Rules\MinRule(0)]);
```

Get required int value. Throws `MissingValueForKeyException` exception if missing.

```php
$value = $data->getRequiredInt('key');
```

### Float

> Throws `ValidationFailedException` if value is not numeric (only on non-null values).

Get nullable float value.

```php
$value = $data->getFloat('key');
```

Get required float value. Throws `MissingValueForKeyException` exception if missing.

```php
$value = $data->getRequiredFloat('key');
```

### Bool

> Throws `ValidationFailedException` if value is not bool (only on non-null values).

Get nullable bool value.

```php
$value = $data->getBool('key');
```

Get required bool value. Throws `MissingValueForKeyException` exception if missing.

```php
$value = $data->getRequiredBool('key');
```

### String

> Throws `ValidationFailedException` if value is not string (only on non-null values).

Get nullable string value.

```php
$value = $data->getString('key');
```

Get required string value. Throws `MissingValueForKeyException` exception if missing.

```php
$value = $data->getRequiredString('key');
```

### Date time

> Throws `ValidationFailedException` if value is not string (only on non-null values).


Get nullable `\DateTime` object (return null if empty string).

```php
$value = $data->getDateTime('key');
```

Get required `\DateTime` object. Throws `MissingValueForKeyException` exception if missing.

```php
$value = $data->getRequiredDateTime('key');
```

### Array

> Throws always `NotAnArrayException` exception if value exists but is not an array.

Get always an array event if provided data is missing or if null.

```php
$value = $data->getArray('key');
```

Get nullable array.

```php
$value = $data->getRequiredArray('key');
```

Get required array that is not empty. Throws `ArrayIsEmptyException` exception if missing.

```php
$value = $data->getRequiredArray('key');
```

### GetValue with ArrayData

> Throws always `NotAnArrayException` exception if value exists but is not an array.

Try to get nullable array from data and wrap it in `GetValue` instance.

```php
$value = $data->getArrayGetter('key');
```

Try to get non-empty array from data and wrap it in `GetValue` instance. Throws `ArrayIsEmptyException` exception if
missing.

```php
$value = $data->getRequiredArrayGetter('key');
```
