<?php

namespace OctoberCloud\Runtime\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'cloud:install';

    protected $description = 'Install the October Cloud runtime into the current app';

    public function handle(): int
    {
        return self::SUCCESS;
    }
}
