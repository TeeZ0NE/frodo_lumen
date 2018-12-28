<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 12/28/18
 * Time: 6:46 PM
 */

use App\Models\{Account, Post};
use Carbon\Carbon;

class CheckIntervalTest extends TestCase{

	public $screen_name = 'adme_ru';
	public $console;

	public function __construct()
	{
		parent::__construct();
		$this->console = new App\Console\Commands\UpdateTweetsByInterval();
	}
	/**
	 * Check get interval
	 * @test-
	 * @return int $interval
	 */
	public function get_interval()
	{
		$interval = Account::where('screen_name', $this->screen_name)->first
		()->interval ?? 0;
		$this->assertNotEquals(0, $interval);

		return $interval;
	}

	/**
	 * Check get when last updated Post
	 * @test-
	 * @return Carbon $r_updated_at
	 */
	public function check_get_updated_at()
	{
		$account_id = Account::where('screen_name', $this->screen_name)->first
			()->id;
		$r_updated_at = Post::where('account_id', $account_id)->first()
			->r_updated_at;
		$this->assertNotEmpty($r_updated_at);

		return $r_updated_at;
	}

	/**
	 * compare two dates
	 * @test-
	 * @param int $interval
	 * @param Carbon $r_updated_at
	 * @depends get_interval
	 * @depends check_get_updated_at
	 */
	public function compare_time($interval, $r_updated_at)
	{
		$res = $r_updated_at->addHours($interval)->lessThan(Carbon::now());
		$this->assertTrue($res);
	}

	/**
	 * @test
	 */
	public function check_acc_collect()
	{
		$this->assertNotEmpty($this->console->getAccounts());
	}

	/**
	 * @test-
	 */
	public function check_get_interval()
	{
		$this->assertEquals('genevieve_weissnat',
			$this->console->recurseAccount());
	}
}