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
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;

$data = GetValue(new ArrayData([
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
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\XMLData;
use \SimpleXMLElement;

$simpleXMLElement = new SimpleXMLElement('<root><title>test</title><test attribute="test"/></root>');
$data = new GetValue(new XMLData($simpleXMLElement));
```

## Accessing values

- To get value you are required to pass a key path (for array it is index keys, for XML it is node names).
- There are 2 methods for each data type:

### For values that are optional

Will return null value if the data does not contain value for given key.

```php
// Returns for example 13 or null 
$data->getInt('address.street.number') 
```

### For value that must exists

Ensures that value is present and not null.

```php
// Returns for example 13. For null MissingValueForKeyException is thrown
$data->getInt('address.street.number') 
```

### Dot notation

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;

$data = new GetValue(new ArrayData([
    'street' => ['number' => 13],
]));
// Use dot notation
$data->getInt('street.number') // Returns: 13
// or array key path
$data->getInt(['street', 'number']) // Returns: 13
```

If any key in the path contains a dot character, you need to specify the path as an array of path parts.

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;

$data = new GetValue(new ArrayData([
    'address' => [
        'street.number' => 14,
        'street' => [
            'number' => 13,
        ],
    ]   
]));
$data->getInt('address.street.number') // Returns: 13
$data->getInt(['address', 'street.number']) // Returns: 14
```

You can also access array elements using their ordered numeric index.

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;

$data = new GetValue(new ArrayData([
    'tags' => ['narrow', 'roundabout'] 
]));
// Use dot notation
$data->getString('tags.0') // Returns: narrow
$data->getString('tags.1') // Returns: narrow
// or array key path
$data->getString(['tags', '0']) // Returns: narrow
$data->getString(['tags',  '1']) // Returns: roundabout
```

### Validation

- All values are validated within its type definition (int will be checked by IntegerRule, string by StringRule, etc).
- **Validation occurs only on non-null values.**
- You can additionally add validation rules (as second parameter) to ensure you will get correct value.
  Check [Validation documentation](/validation) for more.

## Supported value types

### Int

> Throws `ValidationFailedException` if value is not numeric. Float is truncated.

Get nullable int.

```php
$value = $data->getInt('key');
```

Get existing non-nullable int value. Throws `MissingValueForKeyException` exception if null.

```php
$value = $data->getRequiredInt('key');
```

### Float

> Throws `ValidationFailedException` if value is not numeric. String value using comma instead of dot are converted to
> valid float. (1200,50 => 1200.50)

Get nullable float value.

```php
$value = $data->getFloat('key');
```

Get existing non-nullable float value. Throws `MissingValueForKeyException` exception if null.

```php
$value = $data->getRequiredFloat('key');
```

### Bool

> **Values
as ['yes','no',1,0,'1','0','true','false'](https://php-get-typed-value.wrk-flow.com/transformers/#transformtobool)
> are converted to bool**. This can be globally changed
> via [strategy](https://php-get-typed-value.wrk-flow.com/transformers#strategy).
> Throws `ValidationFailedException` if value is not bool.

Get nullable bool value.

```php
$value = $data->getBool('key');
```

Get existing non-nullable bool value. Throws `MissingValueForKeyException` exception if null.

```php
$value = $data->getRequiredBool('key');
```

### String

> **String
is [trimmed and empty string is converted to null](https://php-get-typed-value.wrk-flow.com/transformers/#trimandemptystringtonull)**
> .
> This can be globally changed via [strategy](https://php-get-typed-value.wrk-flow.com/transformers#strategy).
> Throws `ValidationFailedException` if value is not bool.


Get nullable string value.

```php
$value = $data->getString('key');
```

Get existing non-nullable string value. Throws `MissingValueForKeyException` exception if null.

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

Get existing non-nullable enum value. Throws `MissingValueForKeyException` exception if missing.

```php
$value = $data->getRequiredEnum('key', MyEnum::class);
```

### Date time

> Throws `ValidationFailedException` if value is not string. Format is not validated and DateTime object will try
> to parse given value.

Get nullable `\DateTime` object (return null if empty string).

```php
$value = $data->getDateTime('key');
```

Get existing non-nullable `\DateTime` object. Throws `MissingValueForKeyException` exception if missing.

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

Get existing non-nullable array that is not empty. Throws `ArrayIsEmptyException` exception if missing.

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

### Get SimpleXMLElement

> Since v0.6.0

Return SimpleXMLElement for given key. Uses `xml` transformer strategy.

```php
$xml = $data->getNullableXML('child');
```

### GetValue with XMLData

> Since v0.6.0. Throws always `NotXMLException` exception if value is not a SimpleXMLElement. XML transformer strategy
> is applied.

Get always `GetValue` instance even if provided data is missing or if null.

```php
$value = $data->getXMLGetter('key');
```

Try to get nullable array from data and wrap it in `GetValue` instance.

```php
$value = $data->getNullableXMLGetter('key');
```

Try to get non-empty array from data and wrap it in `GetValue` instance. Throws `ArrayIsEmptyException` exception if
missing.

```php
$value = $data->getRequiredXMLGetter('key');
```

### GetValue XML attributes

> Since v0.6.0. Throws always `NotXMLException` exception if value is not a SimpleXMLElement. XML transformer strategy
> is applied.

Wraps XML element attributes in GetValue instance (even if attributes are not set in element).

Key contains `@attributes` like `title.@attributes.test`.

```php
 // Access attributes from root data
$rootAttributes = $data->getXMLAttributesGetter();
$rootAttributes->getString('attributeName');

 // Access attributes from given element
$attributes = $data->getXMLAttributesGetter('node');
$attributes->getString('attributeName');
```

### GetObject

> Since v0.6.1

- Allows getting object of specified type.
- You can transform raw value to expected object by using transformers (with `GetterTransformer`)
- Use `getObject` if value is nullable
- Use `getRequiredObject` to throw missing value exception if value is null (since v0.6.2)

```php
use Wrkflow\GetValue\Contracts\GetValueTransformerContract;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Transformers\GetterTransformer;

$data = new GetValue(new ArrayData([
   'person' => ['name' => 'Marco', 'surname' => 'Polo'],
]));

class PersonEntity
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
    ) {
    }
}

class TestEntityTransformer implements GetValueTransformerContract
{
    public function transform(GetValue $value, string $key): PersonEntity
    {
        return new PersonEntity(
            firstName: $value->getRequiredString('name'),
            lastName: $value->getRequiredString('surname'),
        );
    }
}

$person = $this->data->getObject(
    Person::class,
    'person',
    new PersonTransformer()
);
// PersonEntity{firstName=Marco,lastName=Polo}
```

## GetValue factory

> Since v0.6.3

If you want to set own strategy / exception builder to all GetValue you can leverage the `GetValueFactory` that helps
you to create GetValue instances from various sources that the package supports. You can create the instance by your
self, or you can use dependency injection.

```php
// Optionally you can change the strategy / exception builder implementation.
$factory = new \Wrkflow\GetValue\GetValueFactory(
    transformerStrategy: new MyTransformerStrategy(),
    exceptionBuilder: new MyExceptionBuilder(),
);
$getValueArray = $factory->array([]);
$getValueXml = $factory->xml(new SimpleXMLElement('<root />'));
```

Example for [Laravel](/laravel)

## Exceptions

> All exceptions receive full key that was used for getting data. You can receive it by using `$exception->getKey()`

- ArrayIsEmptyException
- MissingValueForKeyException
- NotAnArrayException
- ValidationFailedException

### Notes

- **Full key format**:
    - Parent full key is prepended to the key with '.' separator (if the GetValue instance was constructed from parent
      data).
    - Array notation is converted to dot notation string.
  
