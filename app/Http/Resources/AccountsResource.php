<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class AccountsResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'name' => $this->name,
			'screen_name' => $this->screen_name,
			'interval' => $this->interval,
			'tweets'=>PostResource::collection($this->posts)
		];
	}
}