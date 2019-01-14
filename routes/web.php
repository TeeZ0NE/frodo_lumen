<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix'=>'api/accounts'], function () use ($router){
	$router->post('new',['as' => 'account_new', 'uses'=>'AccountController@store']);
	$router->get('/','AccountController@index');
	$router->get('posts', 'AccountController@indexAllWithPosts');
	$router->post('{screen_name}', 'AccountController@update');
	$router->post('{screen_name}/delete', 'AccountController@delete');
	$router->get('{screen_name}/posts', 'PostController');
});

$router->get('/',['as'=>'accounts','uses'=>'Frontend\AccountsController']);
