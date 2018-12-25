<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AccountsCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
        	$table->charset = 'utf8';
	        $table->collation = 'utf8_unicode_ci';
            $table->increments('id');
            $table->string("screen_name")->index()->unique()->comment('User channel name. Account str_id');
            $table->string('name')->comment('Name from service');
            $table->unsignedMediumInteger('interval')->default(4)->comment('time 4 refresh');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
