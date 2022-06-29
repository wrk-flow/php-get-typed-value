---
title: Validation
subtitle: 'Validate the value is not null.'
position: 2
---

## Rules

- All rules can be combined (all must be successful).
- Except array* `get` methods has `rules` argument.
- You can create your own rules by extending `Wrkflow\GetValue\Contracts\RuleContract`
- You are free to add more rules to this package.

### AlphaDashRule

Checks if the string contains only digits/alphabet/-/_.

```php
$getValue->getString('test', rules: [new \Wrkflow\GetValue\Rules\AlphaDashRule()]);
```

### AlphaNumericRule

Checks if the value is valid IP (using [FILTER_VALIDATE_IP](https://www.php.net/manual/en/filter.filters.flags.php))

```php
$getValue->getString('test', rules: [new \Wrkflow\GetValue\Rules\AlphaNumericRule()]);
```

### ArrayRule

> Not needed if using `getArray*` methods.

Checks if the given value is an array.

```php
$getValue->getArray('test', rules: [new \Wrkflow\GetValue\Rules\ArrayRule()]);
```

### BetweenRule

> Uses SizeRule

Checks if value is withing given range:

- array - count of items equals to given value
- float, int - equals to given value
- bool - equals to given value 1 (true) or 0 (false)
- string - length of string equals to given value

```php
$getValue->getString('test', rules: [new \Wrkflow\GetValue\Rules\BetweenRule(2, 3)]);
$getValue->getInt('test', rules: [new \Wrkflow\GetValue\Rules\BetweenRule(2, 3)]);
$getValue->getArray('test', rules: [new \Wrkflow\GetValue\Rules\BetweenRule(1, 4)]);
$getValue->getFloat('test', rules: [new \Wrkflow\GetValue\Rules\BetweenRule(1.0, 1.5)]);
```

### BooleanRule

> Not needed while using getBool

Checks if the value is a boolean.

```php
$getValue->getString('test', rules: [new \Wrkflow\GetValue\Rules\BooleanRule()]);
```

### EmailRule

Checks if the value is valid e-mail.
Using [FILTER_VALIDATE_EMAIL](https://www.php.net/manual/en/filter.filters.flags.php)

```php
$getValue->getString('test', rules: [new \Wrkflow\GetValue\Rules\EmailRule()]);
```

### FloatRule

> Not needed if using `getFloat*` methods.

Checks if the value is a float.

```php
$getValue->getFloat('test', rules: [new \Wrkflow\GetValue\Rules\FloatRule()]);
```

### HexColorRule

Checks if the value is valid HEX color (alphanumeric string with 3 to 6 chars without or with #).

```php
$getValue->getString('test', rules: [new \Wrkflow\GetValue\Rules\HexColorRule()]);
```

### IntegerRule

> Not needed if using `getInt*` methods.

Checks if the value is a integer.

```php
$getValue->getInt('test', rules: [new \Wrkflow\GetValue\Rules\IntegerRule()]);
```

### IpRule

Checks if the value is valid IP (using [FILTER_VALIDATE_IP](https://www.php.net/manual/en/filter.filters.flags.php))

```php
$getValue->getString('test', rules: [new \Wrkflow\GetValue\Rules\IpRule()]);
```

### MaxRule

> Uses SizeRule

Checks if value is equal or greater than given int/float value.

- array - count of items equals to given value
- float, int - equals to given value
- bool - equals to given value 1 (true) or 0 (false)
- string - length of string equals to given value

```php
$getValue->getString('test', rules: [new \Wrkflow\GetValue\Rules\MaxRule(2)]);
$getValue->getInt('test', rules: [new \Wrkflow\GetValue\Rules\MaxRule(2)]);
$getValue->getArray('test', rules: [new \Wrkflow\GetValue\Rules\MaxRule(1)]);
$getValue->getFloat('test', rules: [new \Wrkflow\GetValue\Rules\MaxRule(1.0)]);
```

### MinRule

Checks if value is equal or lower than given int/float value.

- array - count of items equals to given value
- float, int - equals to given value
- bool - equals to given value 1 (true) or 0 (false)
- string - length of string equals to given value

```php
$getValue->getString('test', rules: [new \Wrkflow\GetValue\Rules\MinRule(2)]);
$getValue->getInt('test', rules: [new \Wrkflow\GetValue\Rules\MinRule(2)]);
$getValue->getArray('test', rules: [new \Wrkflow\GetValue\Rules\MinRule(1)]);
$getValue->getFloat('test', rules: [new \Wrkflow\GetValue\Rules\MinRule(1.0)]);
```

### NumericRule

> Not needed if using `getInt*` methods.

Checks if the value is a numeric.

```php
$getValue->getString('test', rules: [new \Wrkflow\GetValue\Rules\NumericRule()]);
```

### RegexRule

Checks if value is valid against given regex.

```php
$getValue->getString('test', rules: [new \Wrkflow\GetValue\Rules\RegexRule('/[\d]+/')]);
```

### SizeRule

Checks if value is equal to given float/int value:

- array - count of items equals to given value
- float, int - equals to given value
- bool - equals to given value 1 (true) or 0 (false)
- string - length of string equals to given value

```php
$getValue->getString('test', rules: [new \Wrkflow\GetValue\Rules\SizeRule(2)]);
$getValue->getInt('test', rules: [new \Wrkflow\GetValue\Rules\SizeRule(2)]);
$getValue->getArray('test', rules: [new \Wrkflow\GetValue\Rules\SizeRule(1)]);
$getValue->getFloat('test', rules: [new \Wrkflow\GetValue\Rules\SizeRule(1.0)]);
```

### StringRule

> Not needed if using `getString*` methods.

Checks if value is valid string.

```php
$getValue->getString('test', rules: [new \Wrkflow\GetValue\Rules\StringRule()]);
```

### UrlRule

Checks if the value is valid URL (using [FILTER_VALIDATE_URL](https://www.php.net/manual/en/filter.filters.flags.php))

## Notes

- Rules code was extracted from [laurynasgadl/php-validator](https://github.com/laurynasgadl/php-validator) and PHPStan
  8 ready. First I wanted to re-use existing package but did not find.
- I'm thinking of that I will move rules to its own package for more reusability.
