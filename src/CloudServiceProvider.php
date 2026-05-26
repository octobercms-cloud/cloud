<?php

namespace OctoberCloud\Runtime;

use Illuminate\Support\ServiceProvider;
use OctoberCloud\Runtime\Console\InstallCommand;

class CloudServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            InstallCommand::class,
        ]);
    }
}
