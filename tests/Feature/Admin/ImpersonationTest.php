<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

/**
 * NOTA: estos tests usan RefreshDatabase. NO ejecutar contra la base de datos de
 * desarrollo (la borraría). Requieren la conexión de pruebas sqlite :memory:
 * habilitada en phpunit.xml.
 */
class ImpersonationTest extends TestCase
{
    use RefreshDatabase;

    private function bootPermissions(): void
    {
        Permission::firstOrCreate(['name' => 'admin.usuarios.impersonate', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    private function admin(): User
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo('admin.usuarios.impersonate');

        return $admin;
    }

    public function test_user_with_permission_can_impersonate_non_admin(): void
    {
        $this->bootPermissions();
        $admin = $this->admin();
        $target = User::factory()->create();

        $this->actingAs($admin, 'web')
            ->get(route('admin.usuarios.impersonate', $target))
            ->assertRedirect();

        $this->assertSame($target->id, auth()->id());
        $this->assertEquals($admin->id, session('impersonator_id'));
    }

    public function test_cannot_impersonate_self(): void
    {
        $this->bootPermissions();
        $admin = $this->admin();

        $this->actingAs($admin, 'web')
            ->get(route('admin.usuarios.impersonate', $admin));

        $this->assertSame($admin->id, auth()->id());
        $this->assertNull(session('impersonator_id'));
    }

    public function test_cannot_impersonate_another_admin(): void
    {
        $this->bootPermissions();
        $admin = $this->admin();
        $otherAdmin = User::factory()->create();
        $otherAdmin->assignRole('admin');

        $this->actingAs($admin, 'web')
            ->get(route('admin.usuarios.impersonate', $otherAdmin));

        $this->assertSame($admin->id, auth()->id());
        $this->assertNull(session('impersonator_id'));
    }

    public function test_cannot_impersonate_protected_account(): void
    {
        $this->bootPermissions();
        $admin = $this->admin();
        $protected = User::factory()->create(['email' => User::PROTECTED_EMAIL]);

        $this->actingAs($admin, 'web')
            ->get(route('admin.usuarios.impersonate', $protected));

        $this->assertSame($admin->id, auth()->id());
        $this->assertNull(session('impersonator_id'));
    }

    public function test_without_permission_returns_403(): void
    {
        $this->bootPermissions();
        $user = User::factory()->create();
        $target = User::factory()->create();

        $this->actingAs($user, 'web')
            ->get(route('admin.usuarios.impersonate', $target))
            ->assertForbidden();
    }

    public function test_leave_restores_original_user(): void
    {
        $this->bootPermissions();
        $admin = $this->admin();
        $target = User::factory()->create();

        $this->actingAs($admin, 'web')
            ->get(route('admin.usuarios.impersonate', $target));
        $this->assertSame($target->id, auth()->id());

        $this->get(route('admin.usuarios.impersonate.leave'))
            ->assertRedirect(route('admin.users.index'));

        $this->assertSame($admin->id, auth()->id());
        $this->assertNull(session('impersonator_id'));
    }
}
