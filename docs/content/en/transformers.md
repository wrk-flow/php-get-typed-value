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

I've chosen most used combination while working with external services and created `DefaultTransformerStrategy`.

You can disable or [change](#customization) this strategy while constructing `GetValue` instance.

```php
$data = new GetValue(data: $array, transformerStrategy: new NoTransformerStrategy());
```

## Transformers

> Transformers argument in get* methods overrides transformers from strategy.

To disable default transformers set `transformers` argument to empty array.

```php
$getValue = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\ArrayData([
    'key' => ' ',
]));
$value = $getValue->getString('key', []);
// $value === ' '
```

### TransformToBool

Transforms most used representations of boolean in string or number ('yes','no',1,0,'1','0','true','false') and converts
it to bool **before** validation starts.

```php
$getValue = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\ArrayData([
    'key' => 'yes',
]));
$value = $getValue->getBool('key', [new \Wrkflow\GetValue\Transformers\TransformToBool()]);
// $value === true
```

### TrimAndEmptyStringToNull

> Used in DefaultTransformerStrategy

Ensures that string is trimmed and transformed to null (if empty string is provided) **before** validation starts.

```php
$getValue = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\ArrayData([
    'key' => '',
]));
$value = $getValue->getString('key', [new \Wrkflow\GetValue\Transformers\TrimAndEmptyStringToNull()]);
// $value === null
```

### TrimString

Ensures that string is trimmed **before** validation starts.

```php
// Get trimmed string (no '' to null transformation)
$getValue = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\ArrayData([
    'key' => 'Marco Polo ',
]));
$value = $getValue->getString('key', [new \Wrkflow\GetValue\Transformers\TrimString()]);
// $value === 'Marco Polo'
```

### ClosureTransformer

> Can't be used with get\*Array\* methods.

Transforms the value using closure. Ensure you are returning correct type based on the `get` method you have choosed.

```php
$getValue = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\ArrayData([
    'key' => 'Marco Polo',
]));
$transformer = new ClosureTransformer(function (mixed $value, string $key): ?string {
        if ($value === null) {
            return null;
        }

        return md5($value);
    });
$md5 = $getValue->getString('key', [$transformer]);
```

### ArrayTransformer

> Can be used only with get\*Array\* methods.

Transforms valid array using closure. Always return an array.

```php
$getValue = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\ArrayData([
    'key' => ['Marco', 'Polo']
]));
$transformer = new ArrayTransformer(function (array $value, string $key): array {
    return array_map(fn (string $value) => md5($value), $value);
});

$values = $getValue->getArray('key', [$transformer]);
```

### ArrayItemTransformer

> Can be used only with get\*Array\* methods.

Transforms **each value in an array** using closure.

```php
$getValue = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\ArrayData([
    'key' => ['Marco', 'Polo']
]));
$transformer = new ArrayItemTransformer( function (mixed $value, string $key): string {
    if (is_string($value) !== null) {
        throw new ValidationFailedException($key, 'array value not a string');
    }

    return md5($value);
});

$values = $getValue->getArray('key', [$transformer]);
```

### ArrayItemGetterTransformer

> Can be used only with get\*Array\* methods. Throws NotAnArrayException if array value is not an array.

Transforms an **array that contains array values** in a closure that receives wrapped array in GetValue.

```php
$getValue = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\ArrayData([
    'key' => [['test' => 'Marco'], ['test' => 'Polo']]
]));
$transformer = new ArrayItemGetterTransformer( function (\Wrkflow\GetValue\GetValue $value, string $key): string {
    return [
        'test' => $value->getRequiredString('test'),
    ];
});

$values = $getValue->getArray('key', [$transformer]);
```

### ArrayItemGetterTransformer

> Can be used only with get\*Array\* methods.

Transforms an **array** in a closure that receives wrapped array in GetValue.

```php
$getValue = new \Wrkflow\GetValue\GetValue(new \Wrkflow\GetValue\DataHolders\ArrayData([
    'key' => ['test' => 'Value!']
]));
$transformer = new ArrayGetterTransformer( function (\Wrkflow\GetValue\GetValue $value, string $key): string {
    return [
        'test' => $value->getRequiredString('test'),
    ];
});

$values = $getValue->getArray('key', [$transformer]);
```

## Customization

You can create your own transformer by extending:

- For array `Wrkflow\GetValue\Contracts\TransformerArrayContract`
- Reset of values `Wrkflow\GetValue\Contracts\TransformerContract`
- `$key` contains full path key from the root data. Array notation is converted to dot notation.

Then implement `public function transform(mixed $value, string $key): mixed;`. Expect invalid value and make do not
transform the value if it is invalid. Just return it.

Then implement `public function beforeValidation(mixed $value, string $key): bool;` which ensures that transformation
is not done before validation.

Then change the strategy:

```php
$data = new GetValue(data: $array, transformerStrategy: new MyTransformerStrategy());
```
