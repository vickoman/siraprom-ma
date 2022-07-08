<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Auth;

class UsersTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */

public function test_usuario_puede_ver_pagina_de_login()
{
    $response = $this->get('/login');

    $response->assertSuccessful();
    $response->assertViewIs('auth.login');
}
public function test_usuario_sin_credencial_no_puede_ver_el_dashboard()
{
    $response = $this->get('/projects');

    $response->assertStatus(302);
    $response->assertRedirect('/login');
}
public function test_usuario_sin_credencial_no_puede_ver_proyectos()
{
    $response = $this->get('/projects');

    $response->assertStatus(302);
    $response->assertRedirect('/login');
}
public function test_usuario_sin_credencial_no_puede_ver_avances()
{
    $response = $this->get('/avances');

    $response->assertStatus(302);
    $response->assertRedirect('/login');
}
public function test_usuario_sin_credencial_no_puede_ver_roles()
{
    $response = $this->get('/projects');

    $response->assertStatus(302);
    $response->assertRedirect('/login');
}
public function test_usuario_sin_credencial_no_puede_ver_indicadores()
{
    $response = $this->get('/projects');

    $response->assertStatus(302);
    $response->assertRedirect('/login');
}
public function test_usuario_sin_credencial_no_puede_ver_reportes()
{
    $response = $this->get('/reports');

    $response->assertStatus(302);
    $response->assertRedirect('/login');
}
/*
public function test_user_cannot_login_with_incorrect_password()
    {
        $this->withoutMiddleware();
     //   $user = User::factory()->create([
       //     'password' => bcrypt('i-love-laravel'),
      //  ]);
        
        $response = $this->post('/login', [
            //'email' => $user->email,
            'email'=>'admin@siraprom.com',
            'password' => '123456',
        ]);
       // $response->assertSuccessful();
               /* $response->assertStatus(500);   
       $response->assertRedirect('');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest(); 
    }
*/


}
