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
    'key' => ['Marco', 'Polo']
]));
$transformer = new ArrayItemTransformer( function (mixed $value, string $key): string {
    if (is_string($value) !== null) {
        throw new ValidationFailedException($key, 'array value not a string');
    }

    return md5($value);
});

$values = $data->getArray('key', transformers: [$transformer]);
```

### ArrayItemGetterTransformer

> Can be used only with get\*Array\* methods. Throws NotAnArrayException if array value is not an array.

Transforms an **array that contains array values** in a closure that receives wrapped array in GetValue.

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Transformers\ArrayItemGetterTransformer;

$data = new GetValue(new ArrayData([
    'key' => [['test' => 'Marco'], ['test' => 'Polo']]
]));
$transformer = new ArrayItemGetterTransformer( function (GetValue $value, string $key): string {
    return [
        'test' => $value->getRequiredString('test'),
    ];
});

$values = $data->getArray('key', transformers: [$transformer]);
```

### ArrayItemGetterTransformer

> Can be used only with get\*Array\* methods.

Transforms an **array** in a closure that receives wrapped array in GetValue.

```php
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Transformers\ArrayGetterTransformer;

$data = new GetValue(new ArrayData([
    'key' => ['test' => 'Value!']
]));
$transformer = new ArrayGetterTransformer(function (GetValue $value, string $key): string {
    return [
        'test' => $value->getRequiredString('test'),
    ];
});

$values = $data->getArray('key', transformers: [$transformer]);
```

## Customization

You can create your own transformer by extending:

- For array `Wrkflow\GetValue\Contracts\TransformerArrayContract`
- Rest of the value types use `Wrkflow\GetValue\Contracts\TransformerContract`
- `$key` contains full path key from the root data. Array notation is converted to dot notation.

Then implement `public function transform(mixed $value, string $key): mixed;`. Expect that you can receive an invalid
value. Return original `$value` if transformation can't be done.

Then implement `public function beforeValidation(mixed $value, string $key): bool;` which ensures that transformation
is not done before validation.

Then change the strategy:

```php
use Wrkflow\GetValue\GetValue;
use \MyTransformerStrategy;

$data = new GetValue(data: $array, transformerStrategy: new MyTransformerStrategy());
```
