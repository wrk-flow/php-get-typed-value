<?php declare(strict_types=1);

namespace Wrkflow\GetValueTests\Laravel;

use Orchestra\Testbench\Concerns\WithWorkbench;
use Wrkflow\GetValue\Actions\GetValidatedValueAction;
use Wrkflow\GetValue\Contracts\ExceptionBuilderContract;
use Wrkflow\GetValue\Contracts\TransformerStrategyContract;
use Wrkflow\GetValue\Enums\ValueType;
use Wrkflow\GetValue\GetValueFactory;
use Wrkflow\GetValue\Laravel\GetValueServiceProvider;
use Wrkflow\GetValue\Rules\StringRule;
use Wrkflow\GetValue\Strategies\NoTransformerStrategy;
use Wrkflow\GetValueTests\Builders\CustomExceptionBuilder;

final class GetValueServiceProviderTest extends AbstractLaravelTestCase
{
    use WithWorkbench;

    public function testContainerResolvesValidationAndItsDefaultDependencies(): void
    {
        $app = $this->app();
        self::assertTrue($app->bound(ExceptionBuilderContract::class));
        self::assertTrue($app->bound(TransformerStrategyContract::class));

        $factory = $app->make(GetValueFactory::class);
        $action = $app->make(GetValidatedValueAction::class);

        self::assertSame('sample', $action->execute(
            getValue: $factory->array([
                'value' => 'sample',
            ]),
            valueType: ValueType::String,
            key: 'value',
            rules: [new StringRule()],
            transforms: [],
        ));
    }

    public function testRegisterPreservesCustomBindings(): void
    {
        $app = $this->app();
        $builder = new CustomExceptionBuilder();
        $strategy = new NoTransformerStrategy();
        $app->instance(ExceptionBuilderContract::class, $builder);
        $app->instance(TransformerStrategyContract::class, $strategy);
        $app->register(GetValueServiceProvider::class, force: true);

        $factory = $app->make(GetValueFactory::class);
        self::assertSame($builder, $factory->exceptionBuilder);
        self::assertSame($strategy, $factory->transformerStrategy);
    }
}
