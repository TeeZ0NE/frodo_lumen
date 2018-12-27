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
}