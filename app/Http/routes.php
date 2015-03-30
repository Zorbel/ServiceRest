<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

// Political program data functions

Route::group(['prefix' => 'PoliticalParty'], function()
{
	Route::get('/', 'PoliticalPartyController@index');
	
	Route::get('/{id}', 'PoliticalPartyController@show');
});

Route::group(['prefix' => 'getPoliticalProgram'], function()
{
	Route::get('/{id}', 'PoliticalProgramController@show');
	
	Route::get('/{id}/{section_parent}', 'PoliticalProgramController@showSection');
	
	Route::get('/{id_political_party}/{section}/getContent', 'PoliticalProgramController@showSectionText');
});

// Social functions

Route::group(['prefix' => 'social'], function()
{
	Route::get('/getLikes/{id_political_party}/{section}', 'SocialController@getLikes');

	Route::get('/getUnlikes/{id_political_party}/{section}', 'SocialController@getUnlikes');

	Route::get('/addLike/{id_political_party}/{section}', 'SocialController@addLike');

	Route::get('/addUnlike/{id_political_party}/{section}', 'SocialController@addUnlike');

	Route::get('/getComments/{id_political_party}/{section}', 'SocialController@getComments');

	Route::get('/getCommentsCount/{id_political_party}/{section}', 'SocialController@getCommentsCount');

	Route::post('/addComment', 'SocialController@addComment');
});