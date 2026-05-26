<?php

namespace OctoberCloud\Runtime\Console;

use Illuminate\Console\Command;

class CloudInstallCommand extends Command
{
    protected $signature = 'cloud:install';

    protected $description = 'Install the October Cloud runtime into the current app';

    public function handle(): int
    {
        $this->info('October Cloud runtime installed (package discovered successfully).');

        return self::SUCCESS;
    }
}
