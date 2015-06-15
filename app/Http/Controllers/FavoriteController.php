<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
//use Illuminate\Http\Request;
use Request;

class FavoriteController extends Controller {

	const PROPOSALS_QUERY = 'SELECT `id`, `title`, (SELECT `file` FROM `media` WHERE `proposal`.`id_image` = `media`.`id`) AS `id_image`, `views`, `likes`, `not_understood`, `dislikes`, `date`,
						(SELECT `nickname` FROM `user` WHERE `proposal`.`id_user` = `user`.`id`) AS `user`,
 						(SELECT COUNT(*) FROM `comment` WHERE `comment`.`id_proposal` = `proposal`.`id`) AS `comments`
 						FROM `proposal`, `favorites`';

	const SECTIONS_QUERY = 'SELECT `section`.`id_political_party`, `section`.`section`, `title`,
							(SELECT `name` FROM `category` WHERE `category`.`id` = `section`.`id_category`) AS `category`,
							`likes`, `not_understood`, `dislikes`, `views`, 
							(SELECT COUNT(*) FROM `comment` WHERE `section`.`id_political_party` = `comment`.`id_political_party` AND `section`.`section` = `comment`.`section`) AS `comments`
					   		FROM `section`, `favorites`';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Request::only('id_user', 'section', 'id_political_party', 'id_proposal');

		if (is_null($input['id_proposal']))
		{
			if (is_null($input['id_user']) || is_null($input['section']) || is_null($input['id_political_party'] || is_null($input['id_proposal'])))
				return response("Missing parameters", 400);

			else
			{
				DB::insert('INSERT INTO `favorites` (`id_user`, `section`, `id_political_party`) VALUES (?, ?, ?)', 
					array($input['id_user'], $input['section']), $input['id_political_party']);
				return response("Created", 201);
			}

		} elseif (is_null($input['section']) && is_null($input['id_political_party'])) {
			
			if (is_null($input['id_user']) || is_null($input['id_proposal']))
				return response("Missing parameters", 401);
			
			else
			{
				DB::insert('INSERT INTO `favorites` (`id_user`, `id_proposal`) VALUES (?, ?)', array($input['id_user'], $input['id_proposal']));
				return response("Created", 201);
			}
		}

		else
			return response("Unexpected error", 500);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$input = Request::only('id_user', 'section', 'id_political_party', 'id_proposal');

		switch ($id) {
			case "section":
				DB::delete('DELETE FROM `favorites` WHERE `id_user` = ? AND `section` = ? AND `id_political_party` = ?', array($input['id_user'], $input['section'], $input['id_political_party']));
				return response("Accepted", 200);

			case "proposal":
				DB::delete('DELETE FROM `favorites` WHERE `id_user` = ? AND `id_proposal` = ?', array($input['id_user'], $input['id_proposal']));
				return response("Accepted", 200);

			default:
				# code...
				break;
		}

		return response("Unexpected error", 500);
	}

	public function showUserFavorites($type)
	{
		$input = Request::only('id_user');

		switch ($type) {
			case "proposals":
				return DB::select(self::PROPOSALS_QUERY . ' WHERE `favorites`.`id_proposal` = `proposal`.`id` AND `favorites`.`id_user` = ?', array($input['id_user']));

			case "sections":
				return DB::select(self::SECTIONS_QUERY . ' WHERE `favorites`.`section` = `section`.`section` AND `favorites`.`id_political_party` = `section`.`id_political_party` AND `favorites`.`id_user` = ?'
					, array($input['id_user']));
			
			default:
				# code...
				break;
		}
		return response("Unexpected error", 500);
	}

	public function isFavorite()
	{
		
	}

}
