<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $fillable = [
		'account_id', 'id_str', 'title', 'description', 'created_at', 'favorite_count', 'replies_count', 'retweet_count', 'r_updated_at'
	];

	const CREATED_AT = 'r_created_at';
	const UPDATED_AT = 'r_updated_at';

	public function account()
	{
		return $this->belongsTo(Account::class, 'account_id');
	}

	/**
	 * @param int $account_id
	 * @return mixed
	 */
	public function getUpdateTime(int $account_id)
	{
		if ($r_updated_at = $this::where('account_id', $account_id)->first()) {
			return $r_updated_at->r_updated_at;
		} else {
			return Null;
		}
	}
}
