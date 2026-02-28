<?php

namespace App\Support;

use App\Models\User;

class Roles
{
    /**
     * @return list<string>
     */
    public static function all(): array
    {
        return [
            User::ROLE_SUPER_ADMIN,
            User::ROLE_ADMIN,
            User::ROLE_EDITOR,
            User::ROLE_MEMBER,
        ];
    }

    public static function is_valid(string $role): bool
    {
        return in_array($role, self::all(), true);
    }
}
