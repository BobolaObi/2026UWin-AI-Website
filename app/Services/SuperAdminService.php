<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class SuperAdminService
{
    public function current_user_id(): ?int
    {
        /** @var object|null $row */
        $row = DB::table('super_admins')->where('id', 1)->first();
        if (! $row) {
            return null;
        }

        return isset($row->user_id) ? (int) $row->user_id : null;
    }

    public function exists(): bool
    {
        return $this->current_user_id() !== null;
    }

    public function ensure(User $user): void
    {
        DB::transaction(function () use ($user): void {
            $previous_id = $this->current_user_id();

            DB::table('super_admins')->updateOrInsert(
                ['id' => 1],
                [
                    'user_id' => $user->id,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            if ($previous_id && $previous_id !== $user->id) {
                User::query()->whereKey($previous_id)->update([
                    'role' => User::ROLE_ADMIN,
                    'is_admin' => true,
                ]);
            }

            $user->role = User::ROLE_SUPER_ADMIN;
            $user->is_admin = true;
            $user->save();
        });
    }
}
