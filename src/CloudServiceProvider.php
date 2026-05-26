<?php

namespace OctoberCloud\Runtime;

use Illuminate\Support\ServiceProvider;
use OctoberCloud\Runtime\Console\CloudInstallCommand;

class CloudServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            CloudInstallCommand::class,
        ]);
    }
}
