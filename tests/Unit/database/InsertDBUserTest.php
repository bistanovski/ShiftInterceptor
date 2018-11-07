<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\{WithFaker, WithoutMiddleware};

class InsertDBUserTest extends TestCase
{
    // use DatabaseTransactions;

    /**
     * User creation test
     *
     * @return void
     */
    public function testInsert()
    {
        dump(__METHOD__);

        factory(App\Models\User::class)->create([
            'username' => 'unit_insert-Username',
            'email' => 'unit_insert@shiftray.com'
        ]);

        $this->assertDatabaseHas('Users', ['username' => 'unit_insert-Username', 'email' => 'unit_insert@shiftray.com']);
    }
}
