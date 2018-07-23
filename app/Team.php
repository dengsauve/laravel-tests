<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'size'];

    public function add($user)
    {
        $this->guardAgainstTooManyMembers();

        if ($user instanceof User)
        {
            return $this->members()->save($user);
        }
        else
        {
            foreach($user as $u)
            {
                $this->add($u);
            }
        }
    }

    public function remove($users)
    {
        if ($users instanceof User) {
            return $users->leaveTeam();
        }

        $userIds = array_column($users, 'id');
        $this->members()
            ->whereIn('id', $userIds)
            ->update(['team_id' => null]);
    }

    public function dropAll()
    {
        $this->members()->update(['team_id' => null]);
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function count()
    {
        return $this->members()->count();
    }

    protected function guardAgainstTooManyMembers()
    {
        if($this->count() >= $this->size)
        {
            throw new \Exception();
        }
    }

}
