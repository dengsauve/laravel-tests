<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected $user;

    public function signIn($user = null)
    {
        if (! $user){
            $user = factory(User::class)->create();
        }

        $this->user = $user;
        $this->actingAs($this->user); //$this->be($user) //Also works!
        return $this;
    }

}