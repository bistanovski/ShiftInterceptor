<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\{WithFaker, WithoutMiddleware, DatabaseTransactions};

class DeleteUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * User deletion test
     *
     * @return void
     */
    public function testUserDeletion()
    {
        dump(__METHOD__);

        $user = factory(App\Models\User::class)->make([
            'username' => 'unit_test-Username',
            'email' => 'unit_test@shiftray.com'
        ]);

        $user->save();
        $this->assertDatabaseHas('Users', ['username' => $user->getUserName(), 'email' => $user->getEmail()]);

        $user->delete();
        $this->assertDatabaseMissing('Users', ['username' => $user->getUserName(), 'email' => $user->getEmail()]);
    }
}
