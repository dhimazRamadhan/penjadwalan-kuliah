<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{

    public function test_register()
    {
        $data = [
            'name'      => 'test',
            'email'     => time().'test@example.com',
            'password'  => 'secret1234',
            'password_confirmation' => 'secret1234'
        ];

        //send post request
        $response = $this->json('POST', 'api/register', $data);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        //assert it was secessful
        $response->assertStatus(404);

    }

    public function test_login()
    {
        // Creating Users
        User::create([
            'name' => 'Test',
            'email'=> $email = time().'@example.com',
            'password' => $password = bcrypt('secret1234')
        ]);

        // Simulated landing
        $response = $this->json('POST','api/login',[
            'email' => $email,
            'password' => $password,
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        // Determine whether the login is successful and receive token 
        $response->assertStatus(200);

        //$this->assertArrayHasKey('token',$response->json());

        // Delete users
        User::where('email','test@gmail.com')->delete();
    }
}