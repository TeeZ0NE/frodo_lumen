<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 12/26/18
 * Time: 5:58 PM
 */

namespace App\Http\Libs;

use App\Http\Libs\TwitterAPI;
use App\Models\{Account, Post};

class Statuses uses TwitterApi
{
	public function __construct()
	{
	}

	/**
	 * @return \Generator
	 */
	private function recurseStatuses()
	{
		foreach ($this->getStatuses() as $status){
			yield $status;
		}
	}

	private function getStat(){
		return 12;
	}

}