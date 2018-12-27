<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return array
	 */
	public function toArray($request)
	{
//        return parent::toArray($request);
		return [
			"id_str" => $this->id_str,
			"title" => $this->title,
			"description" => $this->description,
			"created_at" => $this->created_at,
			"reply_count" => $this->replies_count,
			"retweet_count" => $this->retweet_count,
			"favorite_count" => $this->favorite_count,
		];
	}
}