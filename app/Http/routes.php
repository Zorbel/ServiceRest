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

Route::group(['prefix' => 'politicalParty'], function()
{
	Route::get('/', 'PoliticalPartyController@index');
	
	Route::get('/{id}', 'PoliticalPartyController@show');

	// Route Sections

	Route::group(['prefix' => '/{id_political_party}/section'], function()
	{
		Route::get('/', 'SectionController@index');

		Route::get('/{section}', 'SectionController@show');

		Route::group(['prefix' => '/{section}'], function()
			{
				Route::get('/like', 'SectionController@getLikes');

				Route::put('/like', 'SectionController@addLike');

				Route::get('/dislike', 'SectionController@getDislikes');

				Route::put('/dislike', 'SectionController@addDislike');

				Route::get('/notUnderstood', 'SectionController@getNotUnderstoods');

				Route::put('/notUnderstood', 'SectionController@addNotUnderstood');
			});

		// Route Comments

		Route::group(['prefix' => '{section}/comment'], function()
		{
			Route::get('/', 'CommentController@index');

			Route::get('/{id}', 'CommentController@show');

			Route::post('/', 'CommentController@create');
		});

	});
});