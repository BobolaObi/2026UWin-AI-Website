<?php

namespace Tests\Feature;

use App\Models\Leader;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LeadersTest extends TestCase
{
    use RefreshDatabase;

    public function test_leaders_page_is_displayed(): void
    {
        Leader::create([
            'sort_order' => 10,
            'name' => 'Test Leader',
            'title' => 'President',
            'bio' => 'Test bio.',
        ]);

        $this->get('/leaders')
            ->assertOk()
            ->assertSee('Test Leader');
    }

    public function test_admin_can_manage_leaders(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'role' => User::ROLE_ADMIN,
        ]);

        $this->actingAs($admin)->get('/admin/leaders')->assertOk();
        $this->actingAs($admin)->get('/admin/leaders/create')->assertOk();
    }

    public function test_editor_cannot_access_leaders_admin(): void
    {
        $editor = User::factory()->create([
            'role' => User::ROLE_EDITOR,
        ]);

        $this->actingAs($editor)->get('/admin/leaders')->assertForbidden();
    }

    public function test_admin_cannot_set_leader_order(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'role' => User::ROLE_ADMIN,
        ]);

        $this->actingAs($admin)->post('/admin/leaders', [
            'sort_order' => 999,
            'name' => 'Order Test',
        ])->assertRedirect('/admin/leaders');

        $leader = Leader::query()->where('name', 'Order Test')->first();
        $this->assertNotNull($leader);
        $this->assertSame(0, $leader->sort_order);
    }

    public function test_owner_can_set_leader_order(): void
    {
        $owner = User::factory()->create([
            'role' => User::ROLE_SUPER_ADMIN,
        ]);
        DB::table('super_admins')->updateOrInsert(
            ['id' => 1],
            ['user_id' => $owner->id, 'created_at' => now(), 'updated_at' => now()]
        );

        $this->actingAs($owner)->post('/admin/leaders', [
            'sort_order' => 321,
            'name' => 'Owner Order Test',
        ])->assertRedirect('/admin/leaders');

        $leader = Leader::query()->where('name', 'Owner Order Test')->first();
        $this->assertNotNull($leader);
        $this->assertSame(321, $leader->sort_order);
    }
}
