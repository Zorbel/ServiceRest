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
		$input = Request::only(`title`, `text`, `how`, `cost`, `id_category`, `id_user`, `id_image`);

		if (is_null($input['title']) || is_null($input['text']) || is_null($input['how']) || is_null($input['cost']) || is_null($input['id_category']) || is_null($input['id_user']) || is_null($input['id_image']))
			return "Missing parameters";

		else
		{
			if (DB::insert('INSERT INTO `proposal` (`title`, `text`, `how`, `cost`, `id_category`, `id_image`, `date`, `id_user`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
				array($input['title'], $input['text'], $input['how'], $input['cost'], $input['id_category'], $input['id_image'], date('Y-m-d H:i:s'), $input['id_user'])))
				return ProposalController::show(DB::getPdo()->lastInsertId());
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
		DB::update('UPDATE `proposal` SET `views` = `views` + 1 WHERE `id` = ?', array($id));

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

		public function getLikes($id_proposal)
	{
		return DB::select('select `likes` FROM `proposal` WHERE `id` = ?', array($id_proposal));
	}

	/**
	*/
	public function addLike($id_proposal)
	{
		DB::update('update `proposal` SET `likes` = `likes` + 1 WHERE `id` = ?', array($id_proposal));
		return ProposalController::getCounters($id_proposal);
	}

	/**
	*/
	public function getDislikes($id_proposal)
	{
		return DB::select('select `dislikes` FROM `proposal` WHERE `id` = ?', array($id_proposal));
	}

	/**
	*/
	public function addDislike($id_proposal)
	{
		DB::update('update `proposal` SET `dislikes` = `dislikes` + 1 WHERE `id` = ?', array($id_proposal));
		return ProposalController::getCounters($id_proposal);
	}

	/**
	*/
	public function getNotUnderstoods($id_proposal)
	{
		return DB::select('select `not_understood` FROM `proposal` WHERE `id` = ?', array($id_proposal));
	}

	/**
	*/
	public function addNotUnderstood($id_proposal)
	{
		DB::update('update `proposal` SET `not_understood` = `not_understood` + 1 WHERE `id` = ?', array($id_proposal));
		return ProposalController::getCounters($id_proposal);
	}

	/**
	*/
	private function getCounters($id_proposal)
	{
		return DB::select('SELECT `likes`, `not_understood`, `dislikes`, `views`, 
							(SELECT COUNT(*) FROM `comment` WHERE `id_proposal` = ?) AS `comments` 
							FROM `proposal` WHERE `id` = ?', array($id_proposal, $id_proposal));		
	}
}