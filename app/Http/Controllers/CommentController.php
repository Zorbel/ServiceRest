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
	public function index()
	{
		return DB::select('select * FROM `comment`');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$input = Request::only('id_political_party', 'section', 'id_user', 'text');

		if (is_null($input['id_political_party']) || is_null($input['section']) || is_null($input['id_user']) || is_null($input['text']))
			return "Missing parameters";

		else
		{
			if (DB::insert('INSERT INTO `comment` (`id_political_party`, `section`, `id_user`, `date`, `text`) VALUES (?, ?, ?, ?, ?)', array($input['id_political_party'], $input['section'], $input['id_user'], date('Y-m-d H:i:s'), $input['text'])))
				return "Comment added";
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