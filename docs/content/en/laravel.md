---
title: Laravel
subtitle: ''
position: 4
---

## Command input

For safe access of command arguments / options you can extend `GetValueFactoryCommand` that provides `$this->inputData`
with wrapped arguments and options in `GetValue` instance.

```php
class MyCommand extends GetValueFactoryCommand {
    protected $signature = 'test {argument} {--option} {--value=}';

    public function handle(): void
    {
        // Ensures that you will get a string 
        $this->inputData->getRequiredString('argument');
        // Get bool (option always return bool)
        $this->inputData->getRequiredBool('option');
        // Returns nullable string
        $this->inputData->getString('value');
    }
}
```

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
- `$this->getValueFactory->command($request);` - Initializes `ArrayData` with command arguments and options.

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

- `Wrkflow\GetValue\Contracts\TransformerStrategyContract $transformerStrategy`
- `Wrkflow\GetValue\Contracts\ExceptionBuilderContract $exceptionBuilder`

*Example for Laravel:*

```php
class MyServiceProvider extends ServiceProvider {
    public function register (): void {
        parent::register();
        
        $this->app->bind(Wrkflow\GetValue\Contracts\TransformerStrategyContract::class, MyTransformerStrategy::class);
        $this->app->bind(Wrkflow\GetValue\Contracts\ExceptionBuilderContract::class, MyExceptionBuilder::class);
    }
}
```
