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
$value = $getValue->getString('key', []);
```

### TransformToBool

Transforms most used representations of boolean in string or number ('yes','no',1,0,'1','0','true','false') and converts
it to bool **before** validation starts.

```php
$getValue->getBool('key', [new \Wrkflow\GetValue\Transformers\TransformToBool()]);
```

### TrimAndEmptyStringToNull

> Used in DefaultTransformerStrategy

Ensures that string is trimmed and transformed to null (if empty string is provided) **before** validation starts.

```php
$getValue->getString('key', [new \Wrkflow\GetValue\Transformers\TrimAndEmptyStringToNull()]);
```

### TrimString

Ensures that string is trimmed **before** validation starts.

```php
// Get trimmed string (no '' to null transformation)
$getValue->getString('key', [new \Wrkflow\GetValue\Transformers\TrimString()]);
```

### ClosureTransformer

> Can't be used with get\*Array\* methods.

Transforms the value using closure. Ensure you are returning correct type based on the `get` method you have choosed.

```php
$transformer = new ClosureTransformer(function (mixed $value, string $key): ?string {
        if ($value === null) {
            return null;
        }

        return md5($value);
    });
$md5 = $getValue->getString('key', [$transformer]);
```

### ClosureArrayTransformer

> Cant be used only with get\*Array\* methods.

Transforms valid array using closure. Always return an array.

```php
$transformer = new ClosureArrayTransformer(function (array $value, string $key): array {
    return array_map(fn (string $value) => md5($value), $value);
});

$values = $getValue->getArray('key', [$transformer]);
```

### ClosureArrayItemsTransformer

> Cant be used only with get\*Array\* methods.

Transforms **each value in an array** using closure.

```php
$transformer = new ClosureArrayTransformer(function (mixed $value, string $key): array {
    // TODO validate your data
    return md5($value);
});

$values = $getValue->getArray('key', [$transformer]);
```

## Customization

You can create your own transformer by extending:

- For array `Wrkflow\GetValue\Contracts\TransformerArrayContract`
- Reset of values `Wrkflow\GetValue\Contracts\TransformerContract`

Then implement `public function transform(mixed $value, string $key): mixed;`. Expect invalid value and make do not
transform the value if it is invalid. Just return it. 

Then implement `public function beforeValidation(mixed $value, string $key): bool;` which ensures that transformation
is not done before validation. 

Then change the strategy:

```php
$data = new GetValue(data: $array, transformerStrategy: new MyTransformerStrategy());
```
