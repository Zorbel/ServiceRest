<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class UserController extends Controller {

	public function getUser($id)
	{
		$result = DB::select('SELECT * FROM `user` WHERE `id` = ?', array($id));

		if (count($result) == 0)
		{
			DB::insert('INSERT INTO `user` (`id`, `email`, `password`) VALUES (?, ?, ?)', array($id, $id . "@democritis.com", UserController::randomPassword()));
			return DB::select('SELECT * FROM `user` WHERE `id` = ?', array($id));
		}

		return $result;
	}

	public function setNickname()
	{
		$input = Request::only(`id_user`, `new_nickname`);

		DB::update('UPDATE `user` SET `nickname` = '?' WHERE `id` = ?;', array($input['new_nickname'], $input['id_user']));
	}

	private function randomPassword() {
	    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }

    	return implode($pass); //turn the array into a string
	}

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
