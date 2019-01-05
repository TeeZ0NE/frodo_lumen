<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 12/25/18
 * Time: 4:07 PM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\{Account, Post};
use App\Http\Libs\{
	StatusMessage, TwitterAPI, StoreStatuses
};
use App\Http\Resources\AccountsResource;

/**
 * Class AccountController
 * @package App\Http\Controllers
 */
class AccountController extends Controller
{
	use TwitterAPI;

	/**
	 * @var int Pagination results per-page. Default is 15
	 */
	private $page_count = 5;

	/**
	 * Get all accounts with posts
	 *
	 * Get all accounts with posts and pagination per $count_results
	 * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
	 */
	public function indexAllWithPosts()
	{
		return AccountsResource::collection(Account::paginate
		($this->page_count));
	}

	/**
	 * Index page with pagination
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index()
	{
		if (collect(Account::getAccountWithPostCount()->get())->isNotEmpty() or collect(Post::first())->isNotEmpty()) {

			return response()->json(
				StatusMessage::statusMessage(
					true,
					'All users with a post count',
					'accounts',
//					Account::getAccountWithPostCount()->paginate($this->page_count)
					Account::getAccountWithPostCount()->get()
				));
		} else {

			return response()->json(StatusMessage::statusMessage(false,
				'Users and Posts not found'));
		}
	}

	/**
	 * Store new user
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request)
	{
		$this->validate($request, ['screen_name' => 'required', 'interval' => 'numeric|min:1']);

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
		} elseif (empty($this->getStatuses()))

			return response()->json(StatusMessage::statusMessage(false,
				sprintf('Tweets not found of this user (%s). No time line yet',
					$this->screen_name)));
		else {
			# store new record
			return $this->storeNewUser($interval);
		}
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function update(Request $request, $screen_name)
	{
		$this->validate($request, ['interval' => 'required|numeric|min:1']);
		$interval = $request->interval;

		if (Account::where('screen_name', $screen_name)->
		update(['interval' => $interval]))

			return response()->
			json(StatusMessage::statusMessage(true,
				sprintf('Interval for %s was updated to %d', $screen_name, $interval)));

		return response()->json(StatusMessage::statusMessage(false,
			sprintf('The %s not found in database and not updated', $screen_name)));
	}

	/**
	 * @param string $screen_name
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(string $screen_name)
	{
		if (Account::where('screen_name', $screen_name)->delete())

			return response()->
			json(StatusMessage::statusMessage(true,
				sprintf('The %s was deleted', $screen_name)));

		return response()->json(StatusMessage::statusMessage(false,
			sprintf('The %s not found and not deleted', $screen_name)));
	}


	/*
	 * ---------------
	 * PRIVATE
	 * ---------------
	 */

	/**
	 * Search screen name in DB
	 *
	 * @param string $screen_name
	 * @return bool
	 */
	private function checkScreenNameInDb(string $screen_name)
	{
		$isFound = collect(Account::where('screen_name', $screen_name)->first
		())->isNotEmpty();

		return $isFound;
	}

	/**
	 * Save new user
	 *
	 * @param int $interval
	 * @return \Illuminate\Http\JsonResponse
	 */
	private function storeNewUser(int $interval)
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