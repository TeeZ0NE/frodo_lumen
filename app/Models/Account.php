<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 12/25/18
 * Time: 3:09 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
	protected $fillable = ['screen_name', 'name', 'interval'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function posts()
	{
		return $this->hasMany(Post::class, 'account_id');
	}

	public static function getAccountWithPostCount()
	{
		return DB::table('accounts as acc')->
		select(DB::raw('name, screen_name, count(posts.id) as posts_number, `interval` as refresh_interval
		'))->
		leftjoin('posts', 'posts.account_id', '=', 'acc.id')->
		groupby(['name', 'screen_name',"acc.interval"]);
	}

	public static function getAccountPosts($screen_name, $limit){
		return DB::table('accounts as acc')->
		select(DB::raw('id_str, title, p.created_at, description, favorite_count, replies_count, retweet_count'))->
		leftjoin('posts as p', 'p.account_id', '=', 'acc.id')->
			where('screen_name',$screen_name)->
		limit($limit);
	}

	public function getAccountsWintervals()
	{
		return $this->select(['id', 'interval', 'screen_name'])->get();
	}
}