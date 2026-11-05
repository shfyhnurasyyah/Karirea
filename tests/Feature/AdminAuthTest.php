<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_login_admin_dapat_diakses(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
        $response->assertSee('Masuk Admin');
    }

    public function test_admin_berhasil_login_dengan_kredensial_valid(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@karirea.id'],
            [
                'name' => 'Administrator KARIREA',
                'password' => Hash::make('password'),
            ]
        );

        $response = $this->post(route('admin.login.post'), [
            'email' => 'admin@karirea.id',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_gagal_jika_password_salah(): void
    {
        $response = $this->from(route('admin.login'))->post(route('admin.login.post'), [
            'email' => 'admin@karirea.id',
            'password' => 'passwordsalah',
        ]);

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_dashboard_admin_hanya_bisa_diakses_setelah_login(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect('/admin/login');
    }

    public function test_admin_dapat_logout_dengan_sukses(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@karirea.id'],
            [
                'name' => 'Administrator KARIREA',
                'password' => Hash::make('password'),
            ]
        );

        $response = $this->actingAs($user)->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
