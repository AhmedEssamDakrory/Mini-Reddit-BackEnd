<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Subscribtion extends Model
{
    protected $fillable = ['username', 'community_id'];
    public $timestamps = false; //so that doesn't expext time columns
    protected $primaryKey = 'subscribtion_id';

    /**
     * [numberOfSubscriptions description].
     *
     * @param int $community_id community_id
     *
     * @return int number of subscriptions
     */
    public static function numberOfSubscriptions($community_id)
    {
        $result = self::where('community_id', $community_id)->count();

        return $result;
    }

    /**
     * checks if the given user subscribed the given community.
     *
     * @param int    $community_id
     * @param string $username
     *
     * @return bool [true if subscribed, false if not ].
     */
    public static function subscribed($community_id, $username)
    {
        $result = self::where('community_id', $community_id)->where('username', $username)->exists();

        return $result;
    }

    /**
     * function to get the communities subsribed by a user given its username.
     *
     * @param string $username
     *
     * @return array [ list of all communities subscribed by the given user ].
     */
    public static function subscribed_communities($username)
    {
        $subscribed_communities = DB::select(" select community_id
        	                              from subscribtions
        	                              where (username='$username')");

        return $subscribed_communities;
    }

    /**
     * function to get the communities subsribed by a user given its username.
     *
     * @param string $username
     *
     * @return array [ list of all communities subscribed by the given user ].
     */
    public static function subscribed_communities_data($username)
    {
        $subscribed_communities = DB::select(" select c.community_id,c.name,c.community_logo
        	                              from subscribtions s ,communities c
        	                              where (username='$username')&&(c.community_id=s.community_id)");

        return $subscribed_communities;
    }

    /**
     * function to store that the given user subscribed the given community.
     *
     * @param string $username     [description]
     * @param int    $community_id [description]
     *
     * @return bool [ true if stored successfully , false if not whatever the reason].
     */
    public static function store($username, $community_id)
    {
        try {
            self::create(['username' => $username, 'community_id' => $community_id]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * function to unsubscribe community given its id and the username of the user.
     *
     * @param string $username
     * @param int    $community_id
     *
     * @return bool [true if deleted successfully , false if not].
     */
    public static function remove($username, $community_id)
    {
        $result = self::where('username', $username)->where('community_id', $community_id)->delete();

        return $result;
    }

    /**
     * this function to create dummmy subscribtion for unit testing.
     *
     * @param int    $community_id
     * @param string $username
     *
     * @return object [the created subscribtion].
     */
    public static function createDummySubscribtion($community_id, $username)
    {
        return self::create(['username' => $username, 'community_id' => $community_id]);
    }
}
