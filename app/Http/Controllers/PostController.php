<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 12/28/18
 * Time: 3:48 PM
 */

namespace App\Http\Controllers;

use App\Models\Account;
use App\Http\Libs\StatusMessage;
use Illuminate\Http\Request;
/**
 * Class PostController
 * @package App\Http\Controllers
 */
class PostController extends Controller
{

	/**
	 * Get user posts (tweets)
	 *
	 * @param Request $request
	 * @param $screen_name
	 * @return \Illuminate\Http\JsonResponse
	* @throws \Illuminate\Validation\ValidationException
	 */
	public function __invoke(Request $request, $screen_name)
	{
		$this->validate($request, ['limit' => 'numeric|min:1']);

		$limit = $request->limit ?? 100;
		$tweets =  Account::getAccountPosts($screen_name, $limit)->get();

		if (collect($tweets)->isNotEmpty())

		return response()->json(
			StatusMessage::statusMessage(
				true, null,'tweets', $tweets));

		return response()->json(StatusMessage::statusMessage(
			false,
			sprintf('User (%s) tweets not found',$screen_name)));
	}
}