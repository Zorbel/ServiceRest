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
		$i = 0;

		foreach ($results as $value) {
			$list[$i] = array("id" => $value->id, "title" => $value->title, 
				"text" => $value->text, "how" => $value->how, "cost" => $value->cost,
				"image" => base64_encode($value->image), "date" => $value->date,
				"id_user" => $value->id_user, "id_group" => $value->id_group,
				"likes" => $value->likes, "not_understood" => $value->not_understood,
				"dislikes" => $value->dislikes);
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
		$input = Request::only(`title`, `text`, `how`, `cost`, `date`, `id_user`);

		return DB::insert('INSERT INTO `proposal` 
			(`title`, `text`, `how`, `cost`, `date`, `id_user`)
			VALUES (?, ?, ?, ?, ?, ?)', 
			array($input['title'], $input['text'], $input['how'], $input['cost'], date('Y-m-d H:i:s'), $input['id_user']));
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
