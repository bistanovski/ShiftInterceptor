<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\{WithFaker, WithoutMiddleware};

class DeleteDBUserTest extends TestCase
{
    // use DatabaseTransactions;

    /**
     * User deletion test
     *
     * @return void
     */
    public function testDelete()
    {
        dump(__METHOD__);

        $user = factory(App\Models\User::class)->make([
            'username' => 'unit_delete-Username',
            'email' => 'unit_delete@shiftray.com'
        ]);

        $user->save();
        $this->assertDatabaseHas('Users', ['username' => $user->getUserName(), 'email' => $user->getEmail()]);

        $user->delete();
        $this->assertDatabaseMissing('Users', ['username' => $user->getUserName(), 'email' => $user->getEmail()]);
    }
}
