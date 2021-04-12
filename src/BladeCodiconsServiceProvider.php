<?php

declare(strict_types=1);

namespace Codeat3\BladeCodicons;

use BladeUI\Icons\Factory;
use Illuminate\Support\ServiceProvider;

final class BladeCodiconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->callAfterResolving(Factory::class, function (Factory $factory) {
            $factory->add('vscode-codicons', [
                'path' => __DIR__.'/../resources/svg',
                'prefix' => 'codicon',
            ]);
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/svg' => public_path('vendor/blade-codicon'),
            ], 'blade-codicon');
        }
    }
}
