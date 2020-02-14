<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHasCategory extends Model
{
    protected $table = 'user_has_categories';
    protected $fillable = ['id','user_id','category_id'];



}
