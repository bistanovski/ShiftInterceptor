<?php

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\{WithFaker, WithoutMiddleware};

class UpdateDBUserTest extends TestCase
{
    // use DatabaseTransactions;

    /**
     * User updating test
     *
     * @return void
     */
    public function testUpdate()
    {
        dump(__METHOD__);

        $user = factory(App\Models\User::class)->make([
            'username' => 'unit_update-Username',
            'email' => 'unit_update@shiftray.com'
            ]);
            
        $user->save();
        $this->assertDatabaseHas('Users', ['username' => $user->getUserName(), 'email' => $user->getEmail()]);
        
        User::firstByEmail($user->getEmail())->update(['username' => 'unit_update-Username-new', 'email' => 'unit_update-new@shiftray.com']);

        $this->assertDatabaseHas('Users', ['username' => 'unit_update-Username-new', 'email' => 'unit_update-new@shiftray.com']);
    }
}
