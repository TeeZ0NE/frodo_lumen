<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PostCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
	        $table->charset = 'utf8mb4';
	        $table->collation = 'utf8mb4_general_ci';
            $table->increments('id');
            $table->unsignedInteger('account_id')->comment('fk 2 account id');
            $table->string('id_str')->nullable()->index()->comment('tweet id');
            $table->string('title')->comment('part of text from service');
            $table->longText('description')->comment('body of text');
            $table->dateTime('created_at')->comment('date and time creation of a tweet from service');
            $table->unsignedMediumInteger('favorite_count')->default(0);
            $table->unsignedMediumInteger('retweet_count')->default(0);
            $table->unsignedMediumInteger('replies_count')->default(0);
            $table->timestamp('r_created_at')->useCurrent();
            $table->timestamp('r_updated_at')->useCurrent();

            $table->foreign('account_id')->references('id')->on('accounts')
	            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('posts', function (Blueprint $table) {
		    $table->dropForeign('posts_account_id_foreign');
	    });

        Schema::dropIfExists('posts');
    }
}
