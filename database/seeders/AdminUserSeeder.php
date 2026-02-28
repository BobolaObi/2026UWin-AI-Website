<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\SuperAdminService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        /** @var \App\Services\SuperAdminService $super_admin_service */
        $super_admin_service = app(SuperAdminService::class);

        $default_admin_email = (string) env('DEFAULT_ADMIN_EMAIL', '');
        $default_admin_name = (string) env('DEFAULT_ADMIN_NAME', 'Admin');
        $default_admin_password = (string) env('DEFAULT_ADMIN_PASSWORD', '');

        if ($default_admin_email === '') {
            $this->command?->warn('DEFAULT_ADMIN_EMAIL is not set; skipping default admin creation.');
            return;
        }

        /** @var \App\Models\User|null $user */
        $user = User::query()->where('email', $default_admin_email)->first();

        if ($user) {
            if (! $super_admin_service->exists()) {
                $super_admin_service->ensure($user);
                $this->command?->info("Default super admin ensured for {$default_admin_email}.");
                return;
            }

            if (! $user->is_admin || $user->role !== User::ROLE_ADMIN) {
                $user->is_admin = true;
                $user->role = User::ROLE_ADMIN;
                $user->save();
            }

            $this->command?->info("Default admin ensured for {$default_admin_email}.");
            return;
        }

        if ($default_admin_password === '') {
            if ((string) env('APP_ENV', 'production') !== 'local') {
                $this->command?->warn('DEFAULT_ADMIN_PASSWORD is not set; skipping default admin creation outside local env.');
                return;
            }

            $default_admin_password = Str::password(20);
            $this->command?->warn('Generated a local DEFAULT_ADMIN_PASSWORD (set it in .env to keep it stable):');
            $this->command?->line($default_admin_password);
        }

        $user = new User();
        $user->name = $default_admin_name;
        $user->email = $default_admin_email;
        $user->password = Hash::make($default_admin_password);
        $user->email_verified_at = now();
        $user->role = $super_admin_service->exists() ? User::ROLE_ADMIN : User::ROLE_SUPER_ADMIN;
        $user->is_admin = $user->role !== User::ROLE_MEMBER;
        $user->save();

        if ($user->role === User::ROLE_SUPER_ADMIN) {
            $super_admin_service->ensure($user);
            $this->command?->info("Created default super admin user: {$default_admin_email}.");
            return;
        }

        $this->command?->info("Created default admin user: {$default_admin_email}.");
    }
}
