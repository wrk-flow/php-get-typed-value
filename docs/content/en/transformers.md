---
title: Transformers
subtitle: 'Transform data to expected state'
position: 3
---

## Features

- All transformers can be combined.
- All `get` methods has `transformers` argument
- You are free to add more transformers to this package.

## Strategy

I've chosen most used combination while working with external services and
created [DefaultTransformerStrategy](https://github.com/wrk-flow/php-get-typed-value/blob/main/src/Strategies/DefaultTransformerStrategy.php)
.

You can disable or [change](#customization) this strategy while constructing `GetValue` instance.

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Strategies\NoTransformerStrategy;

$data = new GetValue(data: $array, transformerStrategy: new NoTransformerStrategy());
```

## Transformers

> Transformers argument in get* methods overrides transformers from strategy.

To disable default transformers set `transformers` argument to empty array.

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;

$data = new GetValue(new ArrayData([
    'key' => ' ',
]));
$value = $data->getString('key', []);
// $value === ' '
```

### TransformToBool

Transforms most used representations of boolean in string or number ('yes','no',1,0,'1','0','true','false') and converts
it to bool **before** validation starts.

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Transformers\TransformToBool;

$data = new GetValue(new ArrayData([
    'key' => 'yes',
]));
$value = $data->getBool('key', transformers: [new TransformToBool()]);
// $value === true
```

### TrimAndEmptyStringToNull

> Used in DefaultTransformerStrategy

Ensures that string is trimmed and transformed to null (if empty string is provided) **before** validation starts.

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Transformers\TrimAndEmptyStringToNull;

$data = new GetValue(new ArrayData([
    'key' => '',
]));
$value = $data->getString('key', transformers: [new TrimAndEmptyStringToNull()]);
// $value === null
```

### TrimString

Ensures that string is trimmed **before** validation starts.

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Transformers\TrimString;

// Get trimmed string (no '' to null transformation)
$data = new GetValue(new ArrayData([
    'key' => 'Marco Polo ',
]));
$value = $data->getString('key', transformers: [new TrimString()]);
// $value === 'Marco Polo'
```

### ClosureTransformer

> Can't be used with get\*Array\* methods.

Transforms the value using closure. Ensure you are returning correct type based on the `get` method you have choosed.

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Transformers\ClosureTransformer;

$data = new GetValue(new ArrayData([
    'key' => 'Marco Polo',
]));
$transformer = new ClosureTransformer(function (mixed $value, string $key): ?string {
        if ($value === null) {
            return null;
        }

        return md5($value);
    });
$md5 = $data->getString('key', transformers: [$transformer]);
```

### ArrayTransformer

> Can be used only with get\*Array\* methods.

Transforms valid array using closure. Always return an array.

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Transformers\ArrayTransformer;

$data = new GetValue(new ArrayData([
    'key' => ['Marco', 'Polo']
]));
$transformer = new ArrayTransformer(function (array $value, string $key): array {
    return array_map(fn (string $value) => md5($value), $value);
});

$values = $data->getArray('key', transformers: [$transformer]);
// Result: ['2231d0878e1f14976c498ad49de37ef6', 'edc23e3209134c89922592669e09cb65']
```

If you want to use this transformer with getString and other non-array method then you need to run the
transformer before validation by setting `beforeValidation: true`.


```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Transformers\ArrayTransformer;

$data = new GetValue(new ArrayData([
   'key' => ['Marco', 'Polo']
]));

$transformer = new ArrayTransformer(
   closure: fn (array $value, string $key): string => implode(' ', $value),
   beforeValidation: true
);

$name = $data->getString('key', transformers: [$transformer]);
$this->assertEquals('Marco Polo', $name);
// Result: Marco Polo
```

### ArrayItemTransformer

> Can be used only with get\*Array\* methods.

Transforms **each value in an array** using closure.

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Transformers\ArrayItemTransformer;
use Wrkflow\GetValue\Exceptions\ValidationFailedException;

$data = new GetValue(new ArrayData([
   'names' => [['Marco', 'Polo'], ['Way', 'Point'], []]
]));
$transformer = new ArrayItemTransformer( function (mixed $value, string $key): string {
   if (is_array($value) !== true) {
       throw new ValidationFailedException($key, 'expecting an array');
   }
   
   if ($value === []) {
        return null;
   }

   return implode(' ', $value);
});

$values = $data->getArray('names', transformers: [$transformer]);
// Result: ['Marco Polo', 'Way Point']
```

If you return `null` in your closure then value is not added to result array. Use `ignoreNullResult: false` in constructor.

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Transformers\ArrayItemTransformer;
use Wrkflow\GetValue\Exceptions\ValidationFailedException;

$data = new GetValue(new ArrayData([
   'names' => ['Marco Polo', 'Way Point', ''],
]));
$transformer = new ArrayItemTransformer(function (mixed $value, string $key): ?array {
   if (is_string($value) === false) {
       throw new ValidationFailedException($key, 'expecting string');
   }

   if ($value === '') {
       return null;
   }

   return explode(' ', $value);
}, ignoreNullResult: false);

$values = $data->getArray('names', transformers: [$transformer]);
// Result: [['Marco', 'Polo'], ['Way', 'Point'], null]
```

### GetterTransformer

> Since v0.6.0

Transforms an **array/xml value** in a closure that receives wrapped GetValue instance.

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Transformers\GetterTransformer;

$data = new GetValue(new ArrayData([
   'person' => ['name' => 'Marco', 'surname' => 'Polo'],
]));

$transformer = new GetterTransformer(function (GetValue $value, string $key): string {
   return $value->getRequiredString('name') . ' '.$value->getRequiredString('surname');
}, beforeValidation: true);

$value = $data->getString('person', transformers: [$transformer]);
// Result: 'Marco Polo'
```

#### Passing object instead of closure

> Since v0.6.1

To make transformers more re-usable you can pass an object that implements `Wrkflow\GetValue\Contracts\GetValueTransformerContract` interface.

```php
use Wrkflow\GetValue\Contracts\GetValueTransformerContract;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Transformers\GetterTransformer;

class GetNameTransformer implements GetValueTransformerContract
{
    public function transform(GetValue $value, string $key): string
    {
        return implode(' ', [$value->getRequiredString('name'), $value->getRequiredString('surname')]);
    }
}

$data = new GetValue(new ArrayData([
   'person' => ['name' => 'Marco', 'surname' => 'Polo'],
]));

$value = $data->getString('person', transformers: [new GetterTransformer(new GetNameTransformer(), true)]);
// Result: 'Marco Polo'
```

### ArrayItemGetterTransformer

> Can be used only with get\*Array\* methods. Throws NotAnArrayException if array value is not an array.

Transforms an **array/xml that contains array/xml values** in a closure that receives wrapped GetValue instance.

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Transformers\ArrayItemGetterTransformer;

$data = new GetValue(new ArrayData([
   'names' => [['name' => 'Marco', 'surname' => 'Polo'], ['name' => 'Martin', 'surname' => 'Way']]
]));

$transformer = new ArrayItemGetterTransformer(fn (GetValue $value, string $key): string => implode(' ', [
   $value->getRequiredString('name'),
   $value->getRequiredString('surname'),
]));

$values = $data->getArray('names', transformers: [$transformer]);
// Result: ['Marco Polo', 'Martin Way']
```

If you return `null` in your closure then value is not added to result array. Use `ignoreNullResult: false` in same way
as in [ArrayItemTransformer](#arrayitemtransformer)`.

#### Passing object instead of closure

> Since v0.6.1

To make transformers more re-usable you can pass an object that implements `Wrkflow\GetValue\Contracts\GetValueTransformerContract` interface.

```php
use Wrkflow\GetValue\Contracts\GetValueTransformerContract;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Transformers\ArrayItemGetterTransformer;

class GetNameTransformer implements GetValueTransformerContract
{
    public function transform(GetValue $value, string $key): string
    {
        return implode(' ', [$value->getRequiredString('name'), $value->getRequiredString('surname')]);
    }
}

$data = new GetValue(new ArrayData([
   'names' => [['name' => 'Marco', 'surname' => 'Polo'], ['name' => 'Martin', 'surname' => 'Way']]
]));

$values = $data->getArray('names', transformers: [new ArrayItemGetterTransformer(new GetNameTransformer())];
// Result: ['Marco Polo', 'Martin Way']
```

## Customization

You can create your own transformer by extending `Wrkflow\GetValue\Contracts\TransformerContract` class:

1. Then implement `public function transform(mixed $value, string $key): mixed;`. Expect that you can receive an invalid
   value. Return original `$value` if transformation can't be done.
2. Then implement `public function beforeValidation(mixed $value, string $key): bool;` which tells if we can transform
   the value after or before validation.
    - Use before validation for transforming value to a type that `get` method expects.
3. You can use `$key` which contains full path key from the root data. Array notation is converted to dot notation.
4. Then change the strategy:

```php
use Wrkflow\GetValue\GetValue;
use \MyTransformerStrategy;

$data = new GetValue(data: $array, transformerStrategy: new MyTransformerStrategy());
```
