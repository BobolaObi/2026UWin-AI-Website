<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'role' => User::ROLE_ADMIN,
        ]);

        $this->actingAs($admin)->get('/admin')->assertOk();
    }

    public function test_admin_can_view_events_admin_page(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'role' => User::ROLE_ADMIN,
        ]);

        $this->actingAs($admin)->get('/admin/events')->assertOk();
    }

    public function test_editor_can_view_events_admin_page_but_not_admin_dashboard(): void
    {
        $editor = User::factory()->create([
            'role' => User::ROLE_EDITOR,
        ]);

        $this->actingAs($editor)->get('/admin/events')->assertOk();
        $this->actingAs($editor)->get('/admin')->assertForbidden();
    }

    public function test_super_admin_can_manage_users(): void
    {
        $owner = User::factory()->create([
            'role' => User::ROLE_SUPER_ADMIN,
        ]);
        DB::table('super_admins')->updateOrInsert(
            ['id' => 1],
            ['user_id' => $owner->id, 'created_at' => now(), 'updated_at' => now()]
        );

        $this->actingAs($owner)->get('/admin/users')->assertOk();
    }
}
