<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
//use Illuminate\Http\Request;
use Request;
class ComparativeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$results = DB::select('SELECT * FROM `comparative`');
		$i = 0;

		foreach ($results as $value) {
			$list[$i] = array(
								"id" => $value->id, 
								"title" => $value->title, 
								"text" => $value->text, 
								"image" => base64_encode($value->image), 
								"date" => $value->date,
								"id_user" => $value->id_user, 
								"id_group" => $value->id_group,
								"views" => $value->views, 
								"likes" => $value->likes, 
								"not_understood" => $value->not_understood, 
								"dislikes" => $value->dislikes
								);
			$i++;
		}

		return $list;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//TODO: Implements insert method on DB
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
