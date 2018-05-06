<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\{WithFaker, WithoutMiddleware, DatabaseTransactions};

class InsertUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * User creation test
     *
     * @return void
     */
    public function testUserCreation()
    {
        dump(__METHOD__);

        factory(App\Models\User::class)->create([
            'username' => 'unit_test-Username',
            'email' => 'unit_test@shiftray.com'
        ]);

        $this->assertDatabaseHas('Users', ['username' => 'unit_test-Username', 'email' => 'unit_test@shiftray.com']);
    }
}
