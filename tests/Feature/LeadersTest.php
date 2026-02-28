<?php

namespace Tests\Feature;

use App\Models\Leader;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}

