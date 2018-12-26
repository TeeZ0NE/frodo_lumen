<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 12/24/18
 * Time: 9:08 PM
 */

namespace App\Http\Libs;

use Abraham\TwitterOAuth\TwitterOAuth;
use Carbon\Carbon;
trait TwitterAPI
{
	private $consumer_key = 'jcd8wIWX2h0IfmCQOIr7OxWke';
	private $consumer_secret = 'gmtPg3Q86UmOYa3hJcTDY7mBkSvx11Fx2uggRI0y93L4sKWzdq';
	private $tokens = [];
	private $twit_connection = null;
	public $screen_name;
	/**
	 * @var array All statuses from user
	 */
	private $statuses = [];
	/**
	 * @var int Count of statuses. Max is 200
	 */
	private $count_statuses = 2;

	public function __construct()
	{
		$this->setTokens();
		$this->setConnection();
		/*$this->middleware(function ($request, $next) {
				if($request->id >= 5) return $next($request);
				return abort(404);
		});*/
	}

	/**
	 * Get Twitter connection with
	 *
	 * @return mixed
	 */
	public function getConnection()
	{
		return $this->twit_connection;
	}

	/**
	 * Get result of last connection
	 * @return bool
	 */
	public function isLastConnectSuccess()
	{
		if ($this->getConnection()->getLastHttpCode() == 200) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get statuses
	 *
	 * Fulla data with links, favorites, shares and User info
	 *
	 * @return array
	 */
	public function getStatuses()
	{
		return $this->statuses;
	}

	/**
	 * Checking errors from request
	 *
	 * @return bool
	 */
	public function checkRequestErrors() : bool
	{
		return isset($this->statuses->errors);
	}

	/**
	 * Get a one descriptive message from errors with
	 *
	 * @param int $index of error
	 * @return string
	 */
	public function getErrorMessage(int $index=0) : string
	{
		if ($index > count($this->getStatuses()->errors)) $index = 0;

		return $this->getStatuses()->errors[$index]->message;
	}

	/**
	 * Get title and description from statuses text object
	 *
	 * @param object $statuses
	 * @return array 0 is Title 1 is Description
	 */
	public function getTitleAndDescription($statuses)
	{
		return explode("\n\n", trim($statuses->text));
	}

	/**
	 * Get Id of status
	 * @param object $statuses
	 * @return int
	 */
	public function getIdStr($statuses) : int
	{
		return $statuses->id ?? 0;
	}

	/**
	 * Get count of retweets
	 *
	 * @param object $statuses
	 * @return int
	 */
	public function getRetweetCount($statuses) : int
	{
		return $statuses->retweet_count ?? 0;
	}

	/**
	 * Get likes count
	 *
	 * @param $statuses
	 * @return int
	 */
	public function getFavoriteCount($statuses) : int
	{
		return $statuses->favorite_count ?? 0;
	}

	/**
	 * Get reply count
	 *
	 * At the moment it blocked tweeter's developers
	 * @param $statuses
	 * @return int
	 */
	public function getReplyCount($statuses) : int
	{
		return $statuses->reply_count ?? 0;
	}

	public function getCreationDate($statuses)
	{
		return Carbon::createFromTimeString($statuses->created_at)->toDateTimeString();
	}

	/**
	 * Get user name (displayed)
	 *
	 * @return string
	 */
	public function getUserName() : string
	{
		return $this->statuses[0]->user->name;
	}

	/*
	*-----------
	*  PRIVATE
	* ----------
	*/
	private function setTokens()
	{
		$this->tokens['access'] = '191610407-1koQyA1dJdVq1kFxiQEGcD5ZDZv4AHYoBx8mV0FJ';
		$this->tokens['secret'] = 'xTUPkpfNqPRyrOh6UpPubAVAV0eetbLzf0PtFcg4Swsg4';
	}

	private function setConnection()
	{
		$this->twit_connection = new TwitterOAuth
		($this->consumer_key,
			$this->consumer_secret, $this->tokens['access'], $this->tokens['secret']);
	}

	/**
	 * Set statuses from Twitter service
	 *
	 * Get statuses for user with channel name (screen_name variable) with
	 * count of statuses as GET parameter, and excluded replies by default,
	 * they are not reachable from service as docs says
	 *
	 * @param bool $exclude_replies
	 */
	private function setStatuses(bool $exclude_replies = true)
	{
		$this->statuses = $this->twit_connection->get('statuses/user_timeline',
			["screen_name" => $this->screen_name,
				"count" => $this->count_statuses, "exclude_replies" =>
				$exclude_replies]);
	}

}