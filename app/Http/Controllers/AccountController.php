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
	StatusMessage, TwitterAPI
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
		$interval = $request->interval;
		# check record in db
		if ($this->checkScreenNameInDb($this->screen_name)) {
			return response()->json(StatusMessage::statusMessage(false,
				sprintf('This user (%s) is in database', $this->screen_name)));
		}

		$this->setStatuses();
		# work Twetter with
		if ($this->checkRequestErrors()) {
			return response()->json(StatusMessage::statusMessage(false,
				$this->getErrorMessage()));
		} else {
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
		return response()->json(StatusMessage::statusMessage(true,
			sprintf('User (%s) stored in database with refresh interval %d hour(s)', $this->screen_name,
				$interval)));
	}
}