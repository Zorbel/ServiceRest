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

	private function showSections($section, $finalList)
	{
		$results = DB::select('select `title`, `section`, `section_parent` FROM `section` WHERE `section_parent` = ?', array($section->section_parent));
		//print_r($results);
		if (is_null($results))
			return $finalList;
		else
		{
			for ($i = 0; $i < count($results); $i++)
			{
				$finalList = $finalList + $results[$i];
				PoliticalProgramController::showSections($results[$i], $finalList);
			}
			return $finalList;
		}
	}

	/**
	* Display the table of contents of the section param
	* @param int $id
	* @param string $section_parent
	* @reutrn Response
	*/
	public function showSection($id, $section_parent)
	{
		return DB::select('select `title` FROM `section` WHERE `id_political_party` = ? AND `section_parent` = ?', array($id, $section_parent));
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
