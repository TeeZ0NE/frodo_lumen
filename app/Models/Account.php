<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 12/25/18
 * Time: 3:09 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
	protected $fillable = ['screen_name', 'name', 'interval'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function posts()	{
		return $this->hasMany(Post::class,'account_id');
	}
}