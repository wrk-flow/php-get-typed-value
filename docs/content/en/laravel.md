---
title: Laravel
subtitle: ''
position: 4
---

## GetValueFormRequest

Allows you access `GetValue` instance within your `FormRequest` by extending `GetValueFormRequest`.

```php
class TestFormRequest extends GetValueFormRequest
{
    final public const KeyTest = 'test';

    public function rules(): array
    {
        return [
            self::KeyTest => ['sometimes', 'string'],
        ];
    }

    public function getTest(): ?string
    {
        return $this->data->getString(self::KeyTest);
    }
}
```

Get value instance uses only validated data.

## GetValueFactory

We have implemented helper functions that pulls array data from Laravel requests:

- `$this->getValueFactory->request($request);` - Initializes `ArrayData` with FormRequest and uses only **validated**
  array data.
- `$this->getValueFactory->requestAll($request);` - Initializes `ArrayData` with **all values** from the requests

```php
class TestAction {
       
    public function __construct(private readonly \Wrkflow\GetValue\GetValueFactory $getValueFactory) {}
    
    public function execute(\Illuminate\Http\Request $request): strin {
        return $this->getValueFactory
            ->request($request)
            ->getRequiredString('test');
    }
}

// 1. Dependency injection, 2. 
$test = app(TestAction::class)->execute();
```

### Dependency injection

To change the implementation using dependency injection just bind contracts below in your framework container:

- `Wrkflow\GetValue\Contracts\TransformerStrategy $transformerStrategy`
- `Wrkflow\GetValue\Contracts\ExceptionBuilderContract $exceptionBuilder`

*Example for Laravel:*

```php
class MyServiceProvider extends ServiceProvider {
    public function register (): void {
        parent::register();
        
        $this->app->bind(Wrkflow\GetValue\Contracts\TransformerStrategy::class, MyTransformerStrategy::class);
        $this->app->bind(Wrkflow\GetValue\Contracts\ExceptionBuilderContract::class, MyExceptionBuilder::class);
    }
}
```
