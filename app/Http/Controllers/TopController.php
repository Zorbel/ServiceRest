<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class TopController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$views = DB::select('SELECT * FROM `section` ORDER BY `views` DESC LIMIT 0, 3');
		$likes = DB::select('SELECT * FROM `section` ORDER BY `likes` DESC LIMIT 0, 3');
		$dislikes = DB::select('SELECT * FROM `section` ORDER BY `dislikes` DESC LIMIT 0, 3');
		$not_understood = DB::select('SELECT * FROM `section` ORDER BY `not_understood` DESC LIMIT 0, 3');
 		$comments = DB::select('SELECT `id_political_party`, `section`, COUNT(`section`) AS `comments` FROM `comment` GROUP BY `section`, `id_political_party` ORDER BY `comments` DESC LIMIT 0, 3');
		
		$results = array("views" => array($views), "likes" => array($likes), "dislikes" => array($dislikes), "not_understood" => array($not_understood), "comments" => array($comments));
		return $results;
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
		//
	}

}
