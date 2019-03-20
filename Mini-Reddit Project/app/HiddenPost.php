<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HiddenPost extends Model
{
    public static function hidden($link_id , $username)
    {
        $result = HiddenPost::where('link_id' , $link_id)->where('user_name' , $username)->exists();
        return $result;
    }
}