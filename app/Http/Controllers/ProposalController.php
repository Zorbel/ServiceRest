<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
//use Illuminate\Http\Request;
use Request;

class ProposalController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$results = DB::select('SELECT * FROM `proposal`');
	}

	public function showCategory($id_category)
	{
		return DB::select('SELECT * FROM `proposal` WHERE `id_category` = ?', array($id_category));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$input = Request::only(`title`, `text`, `how`, `cost`, `date`, `id_user`);

		if (is_null($input['title']) || is_null($input['text']) || is_null($input['how']) || is_null($input['cost']) || is_null($input['date']) || is_null($input['id_user']))
			return "Missing parameters";

		else
		{
			if (DB::insert('INSERT INTO `proposal` (`title`, `text`, `how`, `cost`, `date`, `id_user`)
					VALUES (?, ?, ?, ?, ?, ?)', 
					array($input['title'], $input['text'], $input['how'], $input['cost'], date('Y-m-d H:i:s'), $input['id_user'])))
				return "OK";
			else
				return "Error unexpected";
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return DB::select('SELECT `id`, `title`, `text`, `how`, `cost`,
							(SELECT `file` FROM `media` WHERE `proposal`.`id_image` = `media`.`id`) AS `image`, `date`,
							(SELECT `name` FROM `category` WHERE `proposal`.`id_category` = `category`.`id`) AS `category`,
							(SELECT `nickname` FROM `user` WHERE `proposal`.`id_user`= `user`.`id`) AS `user`,
							`views`, `likes`, `not_understood`, `dislikes`,
							(SELECT COUNT(*) FROM `comment` WHERE `proposal`.`id` = `comment`.`id_proposal`) AS `comments`
							FROM `proposal` WHERE `proposal`.`id` = ?', array($id));
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
		//
	}
}