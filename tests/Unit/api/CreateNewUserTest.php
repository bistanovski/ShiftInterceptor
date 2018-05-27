<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CreateNewUserTest extends TestCase
{
    /**
     * Creating new User through API.
     *
     * @return void
     */
    public function testCreateNewUser()
    {
        dump(__METHOD__);

        $response = $this->json('POST', '/register', [
            'username' => 'ShiftUsername', 
            'email' => 'shift@shiftray.com',
            'password' => 'password'
        ]);
        
        $response->assertStatus(201)->assertJson([
            'success' => true
        ]);
    }


    /**
     * Creating existing User through API.
     *
     * @return void
     */
    public function testCreateExistingUser()
    {
        dump(__METHOD__);

        $response = $this->json('POST', '/register', [
            'username' => 'ShiftUsername', 
            'email' => 'shift@shiftray.com',
            'password' => 'password'
        ]);
        
        $response->assertStatus(401)->assertJson([
            'success' => false
        ]);
    }
}
