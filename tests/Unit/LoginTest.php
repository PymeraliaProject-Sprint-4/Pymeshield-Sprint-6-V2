<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test view login */
    public function test_user_can_view_a_login()
    {
        $response = $this->get('/');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    /** @test auth login */
    public function login_with_valid_credentials()
    {
        $company = Company::create([
            'name' => 'test company',
            'email' => 'test@test.com',
            'phone' => '666',
            'cif' => 'xxx',
        ]);

        $user = User::create([
            'name' => 'test',
            'last_name' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'phone' => '666',
            'nick_name' => 'test_nick',
            'type' => 'admin',
            'company_id' => $company->id,
        ]);

        $response = $this->post('/', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }


}
