<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $table = 'followers';
    protected $fillable = ['id','follower_user_id','followed_user_id'];

}
