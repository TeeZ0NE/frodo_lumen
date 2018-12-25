<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 12/25/18
 * Time: 4:22 PM
 */

use App\Models\Account;

class AccountsTest extends TestCase
{
	public $acc_c;

	public function setUp()
	{
		$this->acc_c = new App\Http\Controllers\AccountController();
		parent::setUp();
	}

	/**
	 * Screen name fail
	 * @test
	 */
	public function storeNewUserValidationScreenNameFail()
	{
		$this->json('POST', '/api/accounts/new',
			['screen_name' => '', 'interval' => 2])
			->seeJsonEquals([
				'screen_name' => ['The screen name field is required.']
			]);
	}

	/**
	 * Check screen_name in DB
	 * @test
	 */
	public function checkScreenNameDb()
	{
		$this->assertTrue($this->acc_c->checkScreenNameInDb('bradley_runolfsson'));
	}

	/**
	 * Interval not number
	 * @test
	 */
	public function storeNewUserValidationInervalFail()
	{
		$this->json('POST', '/api/accounts/new',
			['screen_name' => 'bradley_runolfsson', 'interval' => 'sss'])
			->seeJsonEquals([
				"interval" => ["The interval must be a number."]
			]);
	}

	/**
	 * Validation is Ok
	 * @test
	 */
	public function storeNewUserValidate()
	{
		$this->json('POST', '/api/accounts/new',
			['screen_name' => 'adme_ru', 'interval' => 10])
			->seeJsonEquals([
				"status" => "success",
				"description" => "User (adme_ru) stored in database with refresh interval 10 hour(s)"
			]);
	}

	/**
	 * User exists
	 * @test
	 */
	public function storeNewUserValidateExists()
	{
		$this->json('POST', '/api/accounts/new',
			['screen_name' => 'bradley_runolfsson', 'interval' => 10])
			->seeJsonEquals([
				"status" => "error",
				"description" => "This user (bradley_runolfsson) is in database"
			]);
	}

	/**
	 * Check User in Tweeter
	 * @test
	 */
	public function checkUserInTweeter()
	{
		$this->json('POST', '/api/accounts/new',
			['screen_name' => 'adme_ru', 'interval' => 10])
			->seeJsonEquals([
				"status" => "success",
				"description" => "User (adme_ru) stored in database with refresh interval 10 hour(s)"
			]);
	}

}