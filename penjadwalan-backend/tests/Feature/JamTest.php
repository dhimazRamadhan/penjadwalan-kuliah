<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Jam;
use App\Models\User;

class JamTest extends TestCase
{
    /**
     * Authenticate user.
     *
     * @return void
     */
    protected function authenticate()
    {
        $user = User::create([
            'name' => 'test',
            'email' => rand(12345,678910).'test@gmail.com',
            'password' => \Hash::make('secret9874'),
        ]);

        if (!auth()->attempt(['email'=>$user->email, 'password'=>'secret1234'])) {
            return response(['message' => 'Login credentials are invaild']);
        }

        return $accessToken = auth()->user()->createToken('authToken')->accessToken;
    }

    /**
     * test create jam.
     *
     * @return void
     */
    public function test_create_jam()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST','api/jam',[
            'range_jam' => '08.00-11.00',
            'aktif' => 'Y',
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(201);
    }

    /**
     * test update jam.
     *
     * @return void
     */
    public function test_update_jam()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT','api/jam/14',[
            'range_jam' => '22.00-23.00',
            'aktif' => 'Y',
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test find jam.
     *
     * @return void
     */
    public function test_find_jam()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','api/jam/9');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test get all jam.
     *
     * @return void
     */
    public function test_get_all_jam()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','api/jam');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test delete jam.
     *
     * @return void
     */
    public function test_delete_jam()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('DELETE','api/jam/9');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
}