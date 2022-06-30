---
title: Introduction
subtitle: 'Get typed (strict mode) values from an Array / XML with basic validation.'
position: 1
---

<img src="https://img.shields.io/badge/PHPStan-8-blue" class="inline-flex" style="margin: 0;" /> 
<img src="https://img.shields.io/badge/PHP-8.1-B0B3D6"  class="inline-flex" style="margin: 0;" />
<img src="https://img.shields.io/endpoint?url=https://gist.githubusercontent.com/pionl/11b884c06da0bf9116ae763d23438ecb/raw/coverage.json"  class="inline-flex" style="margin: 0;" />

## Main features

- 🚀 Retrieve values from Array (JSON) / XML with correct return type with **safe dot notation** support.
- 🏆 **Makes PHPStan / IDE** happy due the type strict return types.
- 🤹‍ **Validation:** Ensures that desired value is in correct type (without additional loop validation).
- 🛠 **Transformers:** Ensures that values are in expected type

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

## Dot notation

Dot notation is implemented in safe manner (may differ from Laravel and other implementations when edge cases occurs).

String that is separated by '.' will always be converted to path of exact path keys. If you '.' in your array key / XML
node name
then you need to use array as a key. Examples below:

```php
$getValue = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\ArrayData([
    'get.key' => 'test',
    'get' => [
        'key' => 'child'
    ],
    'co.uk' => 'domain',
]));
$getValue->getString('get.key') // Returns: child
$getValue->getString('co.uk') // Returns: null
$getValue->getString(['get.key']) // Returns: test
$getValue->getString(['co.uk']) // Returns: domain
```

This implementation ensures.

You can instead of dot notation use array path:

```php
$getValue = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\ArrayData([
    'get' => [
        'key' => 'child'
    ],
]));
$getValue->getString(['get', 'key']) // Returns: test
$getValue->getString(['get', 'no_value']) // Returns: null
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
$value = $data->getInt('key');
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

> **In default strategy string [bool variants](https://php-get-typed-value.wrk-flow.com/transformers/#transformtobool)
are converted to bool**. Throws `ValidationFailedException` if value is not bool (only on non-null values).

Get nullable bool value.

```php
$value = $data->getBool('key');
```

Get required bool value. Throws `MissingValueForKeyException` exception if missing.

```php
$value = $data->getRequiredBool('key');
```

### String

> **In default strategy string is trimmed and empty string is transformed to null**. Throws `ValidationFailedException`
> if value is not string (only on non-null values).

Get nullable string value.

```php
$value = $data->getString('key');
```

Get required string value. Throws `MissingValueForKeyException` exception if missing.

```php
$value = $data->getRequiredString('key');
```

### Enum

> Throws `ValidationFailedException` if value is not in the enum. In default strategy empty string
> is treated as null. Works only on string/int enums.

Get nullable enum value from a string/int.

```php
$value = $data->getEnum('key', MyEnum::class);
```

Get required enum value. Throws `MissingValueForKeyException` exception if missing.

```php
$value = $data->getRequiredEnum('key', MyEnum::class);
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

Get always an array even if provided data is missing or if null.

```php
$value = $data->getArray('key');
```

Get nullable array.

```php
$value = $data->getNullableArray('key');
```

Get required array that is not empty. Throws `ArrayIsEmptyException` exception if missing.

```php
$value = $data->getRequiredArray('key');
```

### GetValue with ArrayData

> Throws always `NotAnArrayException` exception if value exists but is not an array.

Get always `GetValue` instance even if provided data is missing or if null.

```php
$value = $data->getArrayGetter('key');
```

Try to get nullable array from data and wrap it in `GetValue` instance.

```php
$value = $data->getNullableArrayGetter('key');
```

Try to get non-empty array from data and wrap it in `GetValue` instance. Throws `ArrayIsEmptyException` exception if
missing.

```php
$value = $data->getRequiredArrayGetter('key');
```

## Exceptions

> All exceptions receive full key that was used for getting data. You can receive it by using `$exception->getKey()`

- ArrayIsEmptyException
- MissingValueForKeyException
- NotAnArrayException
- ValidationFailedException

## Notes

- **Full key format**:
    - Parent full key is prepended to the key with '.' separator (if the GetValue instance was constructed from parent
      data).
    - Array notation is converted to dot notation string.
  
