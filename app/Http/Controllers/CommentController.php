<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
//use Illuminate\Http\Request;
use Request;

class CommentController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getSectionComment($id_political_party, $section)
	{
		return DB::select('SELECT `user`.`nickname`, `comment`.`text`, `comment`.`date` 
						   FROM `comment`, `user` 
						   WHERE `comment`.`section` = ? AND `comment`.`id_user` = `user`.`id` AND `comment`.`id_political_party` = ?
						   ORDER BY `comment`.`date`', array($section, $id_political_party)
						   );
	}

	public function getProposalComment($id_proposal)
	{
		return DB::select('SELECT `user`.`nickname`, `comment`.`text`, `comment`.`date` 
						   FROM `comment`, `user` 
						   WHERE `comment`.`id_proposal` = ? AND `comment`.`id_user` = `user`.`id`
						   ORDER BY `comment`.`date`', array($id_proposal)
						   );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function newSectionComment($id_political_party, $section)
	{
		$input = Request::only('id_user', 'text');

		if (is_null($id_political_party) || is_null($section) || is_null($input['id_user']) || is_null($input['text']))
			return "Missing parameters";

		else
		{
			if (DB::insert('INSERT INTO `comment` (`id_political_party`, `section`, `id_user`, `date`, `text`) 
							VALUES (?, ?, ?, ?, ?)', array($id_political_party, $section, $input['id_user'], date('Y-m-d H:i:s'), $input['text'])))
				return CommentController::getSectionComment($id_political_party, $section);
			else
				return "Error unexpected";
		}
	}

	public function newProposalComment($id_proposal)
	{
		$input = Request::only('id_user', 'text', 'id_category');

		if (is_null($id_proposal) || is_null($input['id_user']) || is_null($input['text']) || is_null($input['id_category']))
			return "Missing parameters";

		else
		{
			if (DB::insert('INSERT INTO `comment` (`id_proposal`, `id_user`, `date`, `text`) 
							VALUES (?, ?, ?, ?)', array($id_proposal, $input['id_user'], date('Y-m-d H:i:s'), $input['text'])))
				return CommentController::getProposalComment($id_proposal);
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
		return DB::select('select * FROM `comment` WHERE `id` = ?', array($id));
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