<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 12/25/18
 * Time: 4:22 PM
 */

use App\Http\Libs\TwitterAPI;
use App\Http\Libs\StoreStatuses;

class AccountsTest extends TestCase
{
	use TwitterAPI {
		TwitterAPI::__construct as twit_api;
	}

	public $acc_c;
	public $interval = 10;
	public $store_statuses;

	public function __construct()
	{
		parent::__construct();
		self::twit_api();
	}

	public function setUp()
	{
		$this->screen_name = 'adme_ru';
		$this->acc_c = new App\Http\Controllers\AccountController();
//		$this->setStatuses();
//		$this->store_statuses = new StoreStatuses
//		($this->screen_name, $this->getStatuses(), $this->interval);
		parent::setUp();
	}

	/**
	 * Screen name fail
	 * @test-
	 */
	public function storeNewUserValidationScreenNameFail()
	{
		$this->json('POST', '/api/accounts/new',
			['screen_name' => '', 'interval' => $this->interval])
			->seeJsonEquals([
				'screen_name' => ['The screen name field is required.']
			]);
	}

	/**
	 * Check screen_name in DB
	 * @test-
	 */
	public function checkScreenNameDb()
	{
		$this->assertTrue($this->acc_c->checkScreenNameInDb('bradley_runolfsson'));
	}

	/**
	 * Interval not number
	 * @test-
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
	 * @test-
	 */
	public function storeNewUserValidate()
	{
		$this->json('POST', '/api/accounts/new',
			['screen_name' => $this->screen_name, 'interval' => $this->interval])
			->seeJsonEquals([
				"status" => "success",
				"description" => "User ({$this->screen_name}) stored in database with refresh interval 10 hour(s)"
			]);
	}

	/**
	 * User exists
	 * @test-
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
	 * Check connection
	 * @test-
	 */
	public function connection_exists()
	{
		$this->assertNotEmpty($this->getConnection());
	}

	/**
	 * Check statusee are not empty
	 * @test-
	 */
	public function check_statuses()
	{
		$this->assertNotEmpty($this->getStatuses());
	}

	/**
	 * Check title and description
	 * @test-
	 */
	public function check_text_title_descript()
	{
		$this->assertNotEmpty(
			$this->getTitleAndDescription
			($this->getStatuses()[0])
		);
		$this->assertEquals(
			2,
			count($this->store_statuses->getTitleAndDescription
				($this->getStatuses()[0]))
		);
	}

	/**
	 * Get status id
	 * @test-
	 */
	public function check_get_status_id()
	{
		$this->assertEquals(731025004889055232, $this->store_statuses->getIdStr
		($this->getStatuses()[1]));
	}

	/**
	 * get retweet count
	 * @test-
	 */
	public function check_get_retweet_count(){
		$this->assertEquals(22,
			$this->store_statuses->getRetweetCount($this->getStatuses()[0])
			);
	}

	/**
	 * check get favorites count
	 * @test-
	 */
	public function check_get_likes()
	{
		$this->assertEquals(
			101,
			$this->store_statuses->getFavoriteCount($this->getStatuses()[0])
		);
	}
	/**
	 * get user name
	 * @test-
	 */
	public function check_user_name()
	{
		$this->assertEquals("AdMe - Вдохновение",
			$this->store_statuses->getUsername()
		);
	}

	/**
	 * Check reply count by def is 0
	 * @test-
	 */
	public function check_repl_count()
	{
		$this->assertEquals(0,$this->store_statuses->getReplyCount
			($this->getStatuses()[0]));
	}
	/**
	 * get creation date
	 * @test-
	 */
	public function check_creation_date()
	{
		$this->assertEquals("2016-05-13 09:05:14",
			$this->store_statuses->getCreationDate($this->getStatuses()[0])
			);
	}

	/**
	 * store or update new user
	 * @test-
	 */
	public function check_store_uptd_new_user()
	{
//		$this->assertGreaterThan(0,$this->store_statuses->storeAccount());
		$this->assertGreaterThan(0,$this->store_statuses->getAccountId());
	}

	/**
	 * User update
	 * @test-
	 */
	public function updateUserValidateExists()
	{
		$this->json('POST',"/api/accounts/$this->screen_name",
			['interval' => $this->interval])
			->seeJsonEquals([
				'status'=>'success',
				'description'=>"Interval for {$this->screen_name} was updated to {$this->interval}"
			]);
	}

	/**
	 * User update fail
	 * @test-
	 */
	public function updateUserValidaeFail()
	{
		$this->json('POST',"/api/accounts/qwert",
			['interval' => $this->interval])
			->seeJsonEquals([
				'status'=>'error',
				'description'=>"The qwert not found in database and not updated"
			]);
	}
	/**
	 * User delete
	 * @test-
	 */
	public function deleteUserValidateExists()
	{
		$this->json('POST',"/api/accounts/$this->screen_name/delete",
			['interval' => $this->interval])
			->seeJsonEquals([
				'status'=>'success',
				'description'=>"The {$this->screen_name} was deleted"
			]);
	}
	/**
	 * User delete fail
	 * @test-
	 */
	public function deleteUserValidateFail()
	{
		$this->json('POST',"/api/accounts/qwert/delete",
			['interval' => $this->interval])
			->seeJsonEquals([
				'status'=>'error',
				'description'=>"The qwert not found and not deleted"
			]);
	}
}