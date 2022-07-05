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
    public function test_an_action_that_requires_authentication()
    {
        $user = User::factory()->create();
 

                         $response = $this->withSession(['banned' => false])->get('/');
                         $response->assertRedirect('/login');
    }
    public function testIsLoggedInAdmin()  {
        $this->assertTrue(true);
}

}
