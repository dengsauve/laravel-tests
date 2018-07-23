<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Likeability;

class Post extends Model
{
    use Likeability;
}
