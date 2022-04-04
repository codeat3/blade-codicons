<?php

declare(strict_types=1);

namespace Codeat3\BladeCodicons;

use BladeUI\Icons\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

final class BladeCodiconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-codicon', []);

            $factory->add('vscode-codicons', array_merge(['path' => __DIR__ . '/../resources/svg'], $config));
        });
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/blade-codicon.php', 'blade-codicon');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/svg' => public_path('vendor/blade-codicon'),
            ], 'blade-codicon');

            $this->publishes([
                __DIR__ . '/../config/blade-codicon.php' => $this->app->configPath('blade-codicon.php'),
            ], 'blade-codicon-config');
        }
    }
}
