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

    public function remove($user)
    {
        $user->team_id = 0;
        $user->save();
    }

    public function dropAll()
    {
        $this->members()->delete();
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
