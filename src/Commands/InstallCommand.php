<?php

namespace Rocketfirm\Rdrive\Commands;

use Illuminate\Console\Command;
use Rocketfirm\Rdrive\Providers\RdriveServiceProvider;
use Symfony\Component\Console\Input\InputOption;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'rdrive:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Rocket Drive package';

    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production', null]
        ];
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Installing...');

        $this->info('Publishing the config file');
        $this->call('vendor:publish', ['--provider' => RdriveServiceProvider::class, '--tag' => ['config', 'public'], '--force' => $this->option('force')]);

        /**
         * Publish config from `dimsav/laravel-translatable` package
         */
        $this->call('vendor:publish', ['--tag' => ['translatable']]);

        $this->info('Migrating the database tables into your application');
        $this->call('migrate', ['--force' => $this->option('force')]);
    }
}
