<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;

class StartProjectCommand extends Command
{
    protected $signature = 'start:project';

    protected $description = 'run this command to install project.';

    public function handle(StartProject $startProject): void
    {
        $this->migrate();

        $startProject->createAdminUser();

        if (confirm('do you want to create some user?')) {
            $startProject->createUserWithArticle();
        }

    }

    protected function migrate(): void
    {
        info('migrating...');
        $this->call('migrate', ['--force']);
        info('migrated!');
    }
}
