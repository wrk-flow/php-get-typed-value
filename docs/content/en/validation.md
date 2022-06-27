---
title: Validation
subtitle: 'Validate the value is not null.'
position: 2
---

## Rules

- All rules can be combined (all must be successful).
- `get` methods has `rules` parameter. Check IDE autocomplete.
- You can create your own rules by extending `Wrkflow\GetValue\Contracts\RuleContract`
- You are free to add more rules to this package.

### AlphaDashRule

Checks if the string contains only digits/alphabet/-/_.

### AlphaNumericRule

Checks if the value is valid IP (using [FILTER_VALIDATE_IP](https://www.php.net/manual/en/filter.filters.flags.php))

### ArrayRule

Checks if the given value is an array. Not needed if using `getArray*` methods.

### BetweenRule

> Uses SizeRule

Checks if the array|float|int|bool|string|null is within max/min (int/float).

### BooleanRule

Checks if the value is a boolean.

### EmailRule

Checks if the value is valid e-mail (
using [FILTER_VALIDATE_EMAIL](https://www.php.net/manual/en/filter.filters.flags.php))

### FloatRule

Checks if the value is a float.

### IntegerRule

Checks if the value is a integer.

### IpRule

Checks if the value is valid IP (using [FILTER_VALIDATE_IP](https://www.php.net/manual/en/filter.filters.flags.php))

### MaxRule

> Uses SizeRule

Checks if the array|float|int|bool|string|null is equal or greater than given int/float value.

### MinRule

Checks if the array|float|int|bool|string|null is equal or lower than given int/float value.

### NumericRule

Checks if the value is a numeric.

### RegexRule

Checks if value is valid against given regex.

### SizeRule

Checks if:

- array - count of items equals to given value
- float, int - equals to given value
- bool - equals to given value 1 (true) or 0 (false)
- string - length of string equals to given value

### StringRule

Checks if value is valid string.

### UrlRule

Checks if the value is valid URL (using [FILTER_VALIDATE_URL](https://www.php.net/manual/en/filter.filters.flags.php))

## Notes

- Rules code was extracted from [laurynasgadl/php-validator](https://github.com/laurynasgadl/php-validator) and PHPStan
  8 ready. First I wanted to re-use existing package but did not find.
- I'm thinking of that I will move rules to its own package for more reusability.
