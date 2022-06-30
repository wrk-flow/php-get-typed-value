---
title: Custom exceptions
subtitle: 'Provide your own exceptions 🚀'
category: Customization
position: 11
---

In some cases you want to provide your own exceptions (like append custom data to the exception).

For this you need to implement your own `ExceptionBuilder` and provide it when creating `GetValue` instance.

```php
class CustomExceptionBuilder extends 
{
    public function __construct(private readonly array $customLogContext) {}
    
    public function missingValue(string|array $key): Exception
    {
        return new MissingValueForKeyException($key, $this->customLogContext);
    }

    public function arrayIsEmpty(string|array $key): Exception
    {
        return new ArrayIsEmptyException($key, $this->customLogContext);
    }

    public function notAnArray(string|array $key): Exception
    {
        return new NotAnArrayException($key, $this->customLogContext);
    }

    /**
     * @param class-string<RuleContract> $ruleClassName
     */
    public function validationFailed(string|array $key, string $ruleClassName): Exception;
    {
        return new ValidationFailedException($key, $this->customLogContext);
    }
}
```

Build your instance:

```php
$data = new \Wrkflow\GetValue\GetValue(
    new \Wrkflow\GetValue\DataHolders\ArrayData([]), 
    new CustomExceptionBuilder(['message' => 'parsing'])
);
```
