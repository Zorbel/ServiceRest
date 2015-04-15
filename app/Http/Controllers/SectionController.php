<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB; // Need for DB calls
use Illuminate\Http\Request;

class SectionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id_political_party)
	{
		return DB::select('select * FROM `section` WHERE `id_political_party` = ?', array($id_political_party));
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
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id_political_party, $section)
	{
		$result1 = DB::select('SELECT `section`, `title`, `text`, `likes`, `not_understood`, `dislikes` 
							   FROM `section` 
							   WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));

		if (is_null($result1[0]->text))
			$result1[0]->text = "";
		else
			DB::update('UPDATE `section` SET `views` = `views` + 1 WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));

		$result2 = DB::select('select COUNT(*) as comments FROM `comment` WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));

		return array("section" => $result1[0]->section, 
					 "title" => $result1[0]->title, 
					 "text" => $result1[0]->text, 
					 "likes" => $result1[0]->likes, 
					 "not_understood" => $result1[0]->not_understood, 
					 "dislikes" => $result1[0]->dislikes, 
					 "comments" => $result2[0]->comments
					 );
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

	/**
	*/
	public function getLikes($id_political_party, $section)
	{
		return DB::select('select `likes` FROM `section` WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));
	}

	/**
	*/
	public function addLike($id_political_party, $section)
	{
		return DB::update('update `section` SET `likes` = `likes` + 1 WHERE `id_political_party` = ? and `section` = ?', array($id_political_party, $section));
	}

	/**
	*/
	public function getDislikes($id_political_party, $section)
	{
		return DB::select('select `dislikes` FROM `section` WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));
	}

	/**
	*/
	public function addDislike($id_political_party, $section)
	{
		return DB::update('update `section` SET `dislikes` = `dislikes` + 1 WHERE `id_political_party` = ? and `section` = ?', array($id_political_party, $section));
	}

	/**
	*/
	public function getNotUnderstoods($id_political_party, $section)
	{
		return DB::select('select `not_understood` FROM `section` WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));
	}

	/**
	*/
	public function addNotUnderstood($id_political_party, $section)
	{
		return DB::update('update `section` SET `not_understood` = `not_understood` + 1 WHERE `id_political_party` = ? and `section` = ?', array($id_political_party, $section));
	}

}
