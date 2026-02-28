<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
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
            if (! $user->is_admin) {
                $user->is_admin = true;
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
        $user->is_admin = true;
        $user->save();

        $this->command?->info("Created default admin user: {$default_admin_email}.");
    }
}
