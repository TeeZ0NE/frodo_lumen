<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\{
	Account, Post
};
use App\Http\Libs\{
	TwitterAPI, StoreStatuses
};
use Illuminate\Support\Facades\Log;

class UpdateTweetsByInterval extends Command
{
	use TwitterAPI{
		TwitterAPI::__construct as twit_api;
	}
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'tweets:update';
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Check refresh interval and update if need';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		self::twit_api();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$this->recurseAccount();
	}

	/*
	 * ---------------
	 * PRIVATE
	 * ---------------
	 */

	/**
	 * Get all accounts from DB
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	function getAccounts()
	{
		$acc_m = new Account();

		return $acc_m->getAccountsWintervals();
	}

	/**
	 * Comparing time
	 *
	 * If time before last update with add interval less then now() update
	 * @param int $interval
	 * @param Carbon $r_updated_at
	 * @return bool
	 */
	private function compareTime(int $interval, Carbon $r_updated_at): bool
	{
		return $r_updated_at->addHours($interval)->lessThan(Carbon::now());
	}

	/**
	 * @return \Generator
	 */
	private function recurseAccounts()
	{
		foreach ($this->getAccounts() as $account) {
			yield $account;
		}
	}

	/**
	 * Recurse Account and check refresh time
	 * If need it update data in DB and update date time
	 */
	private function recurseAccount()
	{
		$post_m = new Post();
		foreach ($this->recurseAccounts() as $account) {
			$r_updated_at = $post_m->getUpdateTime($account->id);

			if ($r_updated_at and $this->compareTime($account->interval,
					$r_updated_at)) {
				# do update
				$this->screen_name = $account->screen_name;

				$this->setStatuses();
				# error occurs
				if ($this->checkRequestErrors()) {
					Log::warning
					($this->getErrorMessage());
					continue;
				}
				# updating statuses
				$store_statuses = new StoreStatuses($this->screen_name,
					$this->getStatuses(), $account->interval);
				if ($store_statuses->isPostStore()) {
					Log::info(sprintf('Posts for user %s updated',
				$this->screen_name));
				} else {
					Log::error(sprintf('Posts for user %s not stored/updated', $this->screen_name));
				}
			} else {
				continue;
			}
		}
	}
}