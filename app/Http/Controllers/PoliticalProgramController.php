<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB; // Necesario para hacer consultas a BD, cambiarlo por ORM

use Illuminate\Http\Request;

class PoliticalProgramController extends Controller {

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
		return DB::select('select `title`, `section` FROM `section` WHERE `id_political_party` = ?', array($id));
	}

	/**
	* Display the table of contents of the section
	* @reutrn Response
	*/
	public function showSection($id_political_party, $section)
	{
		$result1 = DB::select('select `section`, `title`, `text`, `likes`, `not_understood`, `unlikes` FROM `section` WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));
		$result2 = DB::select('select COUNT(*) as comments FROM `comment` WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));

		$finalResult = array("section" => $result1[0]->section, "title" => $result1[0]->title, "text" => $result1[0]->text, "likes" => $result1[0]->likes, "not_understood" => $result1[0]->not_understood, "unlikes" => $result1[0]->unlikes, "comments" => $result2[0]);
		return response()->json($finalResult);
	}

	public function showSectionText($id_political_party, $section)
	{
		return DB::select('select `title`, `text` FROM `section` WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));
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
