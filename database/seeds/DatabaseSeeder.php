<?php

use Illuminate\Database\Seeder;
use App\Models\{Account, Post};

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
	    factory(Account::class, 10)->create();
	    factory(Post::class, 20)->create();
    }
}
