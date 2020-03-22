<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';
    protected $fillable = ['id','longitude','latitude','user_id'];



	public function createLocation($user_id,$longitude,$latitude){
		$location = new Location();
		$location->user_id = $user_id;
		$location->longitude = $longitude;
		$location->latitude = $latitude;
		$location->save();
	}


}
