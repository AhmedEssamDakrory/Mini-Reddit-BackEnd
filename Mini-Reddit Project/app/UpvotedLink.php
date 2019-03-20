<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpvotedLink extends Model
{

    protected $fillable = ['user_name', 'link_id'];
    public $timestamps = false; //so that doesn't expext time columns

    //function to store an upvoted post given the username and post_id

    public static function store($user_name , $link_id)
    {

      try {

        UpvotedLink::create(['user_name' => $user_name , 'link_id' => $link_id ]);
        return true;

      } catch (\Exception $e) {

        return false;

      }


    }


    //function to remove an upvoted post given the username and post_id

    public static function remove($user_name , $link_id)
    {
        $result = UpvotedLink::where('user_name' , $user_name)->where('link_id' , $link_id)->delete();
        return $result;
    }


    public static function upvoted($link_id , $username)
    {
        $result = UpvotedLink::where('link_id' , $link_id)->where('user_name' , $username)->exists();
        return $result;
    }
}
