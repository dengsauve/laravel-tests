<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Team;
use App\User;

class TeamTest extends TestCase
{
    use DatabaseTransactions;

    public function testTeamHasAName()
    {
        $team = new Team(['name' => "Acme"]);
        $this->assertEquals('Acme', $team->name);
    }

    public function testTeamCanAddMembers()
    {
        $team = factory(Team::class)->create();
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $team->add($user);
        $team->add($user2);

        $this->assertEquals(2, $team->count());
    }

    public function testTeamHasMaxSize()
    {
        $team = factory(Team::class)->create(['size' => 2]);
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();

        $team->add($user);
        $team->add($user2);

        $this->expectException('Exception');
        $team->add($user3);
    }

    public function testItCanAddManyMembersUnlessMaxSize()
    {
        $team = factory(Team::class)->create(['size' => 2]);
        $users = factory(User::class, 3)->create();

        $this->expectException('Exception');
        $team->add($users);
    }

    public function testItCanAddMultipleMembersAtOnce()
    {
        $team = factory(Team::class)->create();

        $users = factory(User::class, 3)->create();

        $team->add($users);
        $this->assertEquals(3, $team->count());
    }

    // tests: remove one member, remove all members
    public function testItCanRemoveOneTeamMember()
    {
        $team = factory(Team::class)->create();
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $team->add($user);
        $team->add($user2);

        $team->remove($user);

        $this->assertEquals(1, $team->count());
    }

    public function testItCanRemoveMultipleMembers()
    {
        $team = factory(Team::class)->create();
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();

        $team->add($user);
        $team->add($user2);
        $team->add($user3);

        $team->remove([$user, $user2]);

        $this->assertEquals(1, $team->count());
    }

    public function testItCanDropAllMembers()
    {
        $team = factory(Team::class)->create();
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $team->add($user);
        $team->add($user2);

        $team->dropAll();

        $this->assertEquals(0, $team->count());
    }

    public function testItCanDropAllMembersAndAddAnotherAfter()
    {
        $team = factory(Team::class)->create();
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $team->add($user);
        $team->add($user2);

        $team->dropAll();

        $this->assertEquals(0, $team->count());

        $user3 = factory(User::class)->create();

        $team->add($user3);
        $this->assertEquals(1, $team->count());
    }
}
