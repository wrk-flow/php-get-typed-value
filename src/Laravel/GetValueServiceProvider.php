<?php declare(strict_types=1);

namespace Wrkflow\GetValue\Laravel;

use Illuminate\Support\ServiceProvider;
use Wrkflow\GetValue\Builders\ExceptionBuilder;
use Wrkflow\GetValue\Contracts\ExceptionBuilderContract;
use Wrkflow\GetValue\Contracts\TransformerStrategyContract;
use Wrkflow\GetValue\Strategies\DefaultTransformerStrategy;

final class GetValueServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bindIf(ExceptionBuilderContract::class, ExceptionBuilder::class);
        $this->app->bindIf(TransformerStrategyContract::class, DefaultTransformerStrategy::class);
    }
}
