<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\User;

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\password;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\text;

class StartProject
{
    public function createAdminUser(): void
    {
        $adminName = text(
            label: 'what is admin name?',
            default: 'admin'
        );

        while (true) {
            $adminEmail = text(
                label: 'what is admin email?',
                default: 'admin@admin.admin'
            );

            if (User::whereEmail($adminEmail)->doesntExist()) {
                break;
            }

            error('this email exists please give me another one.');
        }

        $adminPassword = password(
            label: 'what is admin password?',
            required: true,
        );

        $admin = User::create([
            'name' => $adminName,
            'email' => $adminEmail,
            'email_verified_at' => now(),
            'is_admin' => true,
            'password' => $adminPassword,
        ]);

        info("Admin was created: {$admin->toJson()}");
    }

    public function createUserWithArticle(): void
    {
        $userCount = text(
            label: 'how many users create?',
            default: 5
        );

        $articleCount = text(
            label: 'these user has how many articles?',
            default: 5
        );

        spin(
            callback: fn () => User::factory($userCount)
                ->has(Article::factory($articleCount))
                ->create(),
            message: 'Creating users',
        );
    }
}
