<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 12/26/18
 * Time: 5:58 PM
 */

namespace App\Http\Libs;

use Carbon\Carbon;
use App\Models\{
	Account, Post
};

class StoreStatuses
{
	protected $screen_name;
	protected $statuses;
	protected $interval;
	private $account_id;
	private $is_post = false;

	/**
	 * StoreStatuses constructor.
	 * @param string $screen_name
	 * @param array $statuses
	 * @param int $interval
	 */
	public function __construct(string $screen_name, array $statuses, int $interval)
	{
		$this->screen_name = $screen_name;
		$this->statuses = $statuses;
		$this->interval = $interval;

		$this->doStore();
	}

	/**
	 * Get title and description from statuses text object
	 *
	 * @param object $status
	 * @return array 0 is Title 1 is Description
	 */
	public function getTitleAndDescription($status)
	{
		return explode("\n\n", trim($status->text));
	}

	/**
	 * Get Id of status
	 * @param object $status
	 * @return string
	 */
	public function getIdStr($status): string
	{
		return $status->id_str ?? 0;
	}

	/**
	 * Get count of retweets
	 *
	 * @param object $status
	 * @return int
	 */
	public function getRetweetCount($status): int
	{
		return
			$status->retweeted_status->retweet_count ??
			$status->retweet_count ??
			0;
	}

	/**
	 * Get likes count
	 *
	 * @param $status
	 * @return int
	 */
	public function getFavoriteCount($status): int
	{
		return
			$status->retweeted_status->favorite_count ??
			$status->favorite_count ??
			0;
	}

	/**
	 * Get reply count
	 *
	 * At the moment it blocked tweeter's developers
	 * @param $status
	 * @return int
	 */
	public function getReplyCount($status): int
	{
		return
			$status->reply_count ?? 0;
	}

	public function getCreationDate($status)
	{
		return Carbon::createFromTimeString($status->created_at)->toDateTimeString();
	}

	/**
	 * Get user name (displayed)
	 *
	 * @return string
	 */
	public function getUserName(): string
	{
		return $this->statuses[0]->user->name;
	}

	/**
	 * get account id after storing or updating
	 *
	 * @return int|mixed
	 */
	public function getAccountId()
	{
		return $this->account_id;
	}

	/**
	 * get result after post storing
	 *
	 * @return bool
	 */
	public function isPostStore()
	{
		return $this->is_post;
	}

	/*
	 * ---------------
	 * PRIVATE
	 * ---------------
	 */

	/**
	 * @return \Generator
	 */
	private function recurseStatuses()
	{
		foreach ($this->statuses as $status) {
			yield $status;
		}
	}

	/**
	 * Store or update new Account
	 * @return void
	 */
	function storeAccount()
	{
		$account_m = Account::updateOrCreate
		(['screen_name' => $this->screen_name], ['name' => $this->getUserName(), 'interval' => $this->interval]);

		$this->account_id = $account_m->id;
	}

	private function doStore()
	{
		$this->storeAccount();


		foreach ($this->recurseStatuses() as $status) {
			$this->is_post = false;
			$text = $this->getTitleAndDescription($status);
			$post_m = Post::updateOrCreate(
				['account_id' => $this->getAccountId(), 'id_str' => $this->getIdStr($status),],
				[
					'title' => $text[0],
					'description' => (isset($text[1])) ? $text[1] : '',
					'created_at' => $this->getCreationDate($status),
					'favorite_count' => $this->getFavoriteCount($status),
					'retweet_count' => $this->getRetweetCount($status),
					'replies_count' => $this->getReplyCount($status),
					'r_updated_at' => Carbon::now(),
				]
			);
			if (!$post_m->id) break;

			$this->is_post = true;
		}
	}
}