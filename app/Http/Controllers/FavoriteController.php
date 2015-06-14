<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
//use Illuminate\Http\Request;
use Request;

class FavoriteController extends Controller {

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
			if (is_null($input['id_user']) || is_null($input['section']) || is_null($input['id_political_party']))
				return Response::make("Missing parameters", 400);

			else
			{
				DB::insert('INSERT INTO `favorites` (`id_user`, `section`, `id_political_party`) VALUES (?, ?, ?)', 
					array($input['id_user'], $input['section']), $input['id_political_party']);
				return Response::make("Created", 201);
			}

		} elseif (is_null($input['section']) && is_null($input['id_political_party'])) {
			
			if (is_null($input['id_user']) || is_null($input['id_proposal']))
				return Response::make("Missing parameters", 400);
			
			else
			{
				DB::insert('INSERT INTO `favorites` (`id_user`, `id_proposal`) VALUES (?, ?)', array($input['id_user'], $input['id_proposal']));
				//return Response::make("Created", 201);
				return "ok";
			}
		}

		else
			return Response::make("Unexpected error", 500);
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
				DB::delete("DELETE FROM `favorites` WHERE `id_user` = ? AND `section` = ? AND `id_political_party` = ?", array($input['id_user'], $input['section'], $input['id_political_party']));
				return Response::make("OK", 200);

			case "proposal":
				DB::delete("DELETE FROM `favorites` WHERE `id_user` = ? AND `id_proposal` = ?", array($input['id_user'], $input['proposal']));
				return Response::make("OK", 200);

			default:
				# code...
				break;
		}

		return Response::make("Unexpected error", 500);
	}

}
