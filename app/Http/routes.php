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

Route::group(['prefix' => 'top'], function()
{
	Route::get('/', 'TopController@index');

	Route::get('/sections/{resource}', 'TopController@top3Secions');

	Route::get('/sections/{resource}/{rows}', 'TopController@top10Sections');

	Route::get('/proposals/{resource}/{rows}', 'TopController@top10Proposals');

	Route::get('/comparative/{resource}/{rows}', 'TopController@top10Comparatives');
});

Route::group(['prefix' => 'politicalParty'], function()
{
	Route::get('/', 'PoliticalPartyController@index');
	
	Route::get('/{id}', 'PoliticalPartyController@show');

	// Route Sections

	Route::group(['prefix' => '/{id_political_party}/section'], function()
	{
		Route::get('/', 'SectionController@index');

		Route::post('/{section}', 'SectionController@show');

		Route::group(['prefix' => '/{section}'], function()
			{				
				Route::get('/like', 'SectionController@getLikes');

				Route::get('/dislike', 'SectionController@getDislikes');

				Route::get('/notUnderstood', 'SectionController@getNotUnderstoods');
			});

		// Route Comments

		Route::group(['prefix' => '{section}/comment'], function()
		{
			Route::get('/', 'CommentController@getSectionComment');

			Route::get('/{id}', 'CommentController@show');

			Route::post('/', 'CommentController@newSectionComment');
		});

	});
});

Route::put('/', 'SectionController@setOpinion');

// Route Proposals

Route::group(['prefix' => 'proposal'], function()
{
	Route::get('/', 'ProposalController@index');

	Route::post('/{id}', 'ProposalController@show');

	Route::get('/user/{id}', 'ProposalController@showUserProposals');

	Route::get('/colaborative/user/{id}', 'ProposalController@showUserColaborativeProposals');

	Route::get('/{id}/comment', 'CommentController@getProposalComment');

	Route::post('/{id}/comment', 'CommentController@newProposalComment');

	Route::get('/category/{id_category}', 'ProposalController@showCategory');

	Route::post('/', 'ProposalController@create');

	Route::put('/', 'ProposalController@setOpinion');
});

// Route categories

Route::group(['prefix' => 'category'], function()
{
	Route::get('/{id_category}/section/{rows}', 'CategoryController@getSections');

	Route::get('/{id_category}/proposal/{rows}', 'CategoryController@getProposals');

	Route::get('/{id_category}/proposal/{order}/{limit}', 'CategoryController@getProposalsByOrder');
});

Route::group(['prefix' => 'user'], function()
{
	Route::get('/{id}', 'UserController@getUser');

	Route::post('/', 'UserController@setNickname');

	Route::post('/preferences', 'UserController@getUserPreferences');
});

Route::group(['prefix' => 'favorite'], function()
{
	Route::post('/{type}', 'FavoriteController@showUserFavorites');

	Route::post('/', 'FavoriteController@store');
});