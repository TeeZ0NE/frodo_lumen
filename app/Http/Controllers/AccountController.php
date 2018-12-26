<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 12/25/18
 * Time: 4:07 PM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Account;
use App\Http\Libs\{
	StatusMessage, TwitterAPI, StoreStatuses
};


class AccountController extends Controller
{
	use TwitterAPI;

	public function store(Request $request)
	{
		$this->validate($request, [
			'screen_name' => 'required',
			'interval' => 'numeric'
		]);

		$this->screen_name = $request->screen_name;
		$interval = $request->interval ?? 4;
		# check record in db
		if ($this->checkScreenNameInDb($this->screen_name)) {
			return response()->json(StatusMessage::statusMessage(false,
				sprintf('This user (%s) is in database', $this->screen_name)));
		}

		$this->setStatuses();
		# work Twitter with errors or not found on service
		if ($this->checkRequestErrors()) {
			return response()->json(StatusMessage::statusMessage(false,
				$this->getErrorMessage()));
		}
		elseif (empty($this->getStatuses()))
			return response()->json(StatusMessage::statusMessage(false,
			sprintf('Tweets not found this user (%s). No time line yet',
				$this->screen_name)));
		else {
			# store new record
			return $this->storeNewUser($interval);
		}
	}

	/*
	 * ---------------
	 * PRIVATE
	 * ---------------
	 */

	function checkScreenNameInDb(string $screen_name)
	{
		$isFound = collect(Account::where('screen_name', $screen_name)->first
		())->isNotEmpty();

		return $isFound;
	}

	function storeNewUser(int $interval)
	{
		$store_statuses = new StoreStatuses(
			$this->screen_name, $this->getStatuses(), $interval
		);
		if ($store_statuses->getAccountId()) {
			switch ($store_statuses->isPostStore()) {
				case true:
					$msg = 'The user (%s) is stored in the database. Refresh interval %d hour(s)';
					break;
				default:
					$msg = 'The user (%s) is stored in the database, but there is no tweets. Probably not yet. Refresh interval %d hour(s)';
			}

			return response()->json(StatusMessage::statusMessage(true,
				sprintf($msg, $this->screen_name, $interval)));

		} else {

			return response()->json(StatusMessage::statusMessage(false,
				sprintf('The user with screen name %s didn\'t store',
					$this->screen_name)));
		}
	}
}