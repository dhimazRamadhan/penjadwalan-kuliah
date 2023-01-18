<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\WktTdkBersedia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class WktTdkBersediaTest extends TestCase
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
     * test create.
     *
     * @return void
     */
    public function test_create_wkttdkbersedia()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST','api/WktTdkBersedia',[
            'id_dosen' => '1',
            'id_hari'=> '1',
            'id_hari' => '1',
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(201);
    }

    /**
     * test update.
     *
     * @return void
     */
    public function test_update_wkttdkbersedia()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT','api/WktTdkBersedia/14',[
            'id_dosen' => '1',
            'id_hari'=> '1',
            'id_hari' => '1',
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test find.
     *
     * @return void
     */
    public function test_find_wkttdkbersedia()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','api/WktTdkBersedia/1');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test get all.
     *
     * @return void
     */
    public function test_get_all_wkttdkbersedia()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','api/WktTdkBersedia');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test delete.
     *
     * @return void
     */
    public function test_delete_wkttdkbersedia()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('DELETE','api/WktTdkBersedia/1');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
}