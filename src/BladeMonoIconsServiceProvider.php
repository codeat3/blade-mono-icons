<?php

declare(strict_types=1);

namespace Codeat3\BladeMonoIcons;

use BladeUI\Icons\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

final class BladeMonoIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-mono-icons', []);

            $factory->add('mono-icons', array_merge(['path' => __DIR__ . '/../resources/svg'], $config));
        });
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/blade-mono-icons.php', 'blade-mono-icons');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/svg' => public_path('vendor/blade-mono-icons'),
            ], 'blade-mono-icons');

            $this->publishes([
                __DIR__ . '/../config/blade-mono-icons.php' => $this->app->configPath('blade-mono-icons.php'),
            ], 'blade-mono-icons-config');
        }
    }
}
