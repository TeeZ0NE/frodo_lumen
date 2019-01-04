<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 1/3/19
 * Time: 1:22 PM
 */

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Models\Account;

class AccountsController extends Controller
{
	public function index()
	{
		return view('main')->with(['users'=>Account::getAccountWithPostCount
			()->get()]);
	}
}