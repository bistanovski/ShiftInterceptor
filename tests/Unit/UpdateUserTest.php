<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\{WithFaker, WithoutMiddleware, DatabaseTransactions};

class UpdateUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * User updating test
     *
     * @return void
     */
    public function testUserUpdate()
    {
        $user = factory(App\Models\User::class)->make([
            'username' => 'unit_test-Username',
            'email' => 'unit_test@shiftray.com'
            ]);
            
            $user->save();
            $this->assertDatabaseHas('Users', ['username' => $user->getUserName(), 'email' => $user->getEmail()]);
            
            $user->username = 'unit_test-Username-updated';
            $user->email = 'unit_test-updated@shiftray.com';
            $user->save();
            $this->assertDatabaseHas('Users', ['username' => 'unit_test-Username-updated', 'email' => 'unit_test-updated@shiftray.com']);
          
        dump(__METHOD__);
    }
}
