<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class SocialController extends Controller {

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

	public function getLikes($id_political_party, $section)
	{
		$result =  DB::select('select `likes` FROM `section` WHERE `id_political_party` = ? and `section` = ?', array($id_political_party, $section));
		return $result[0]->likes;
	}

	public function getUnlikes($id_political_party, $section)
	{
		$result = DB::select('select `unlikes` FROM `section` WHERE `id_political_party` = ? and `section` = ?', array($id_political_party, $section));
		return $result[0]->likes;
	}

	/**
	* Adds one like at this section passed by param. If everything ok, return '1' else returns nothing.
	*
	* @param int $id_political_party
	* @param int $section
	*/
	public function addLike($id_political_party, $section)
	{
		return DB::update('update `section` SET `likes` = `likes` + 1 WHERE `id_political_party` = ? and `section` = ?', array($id_political_party, $section));
	}

	/**
	* Adds one unlike at this section passed by param. If everything ok, return '1' else returns nothing.
	*
	* @param int $id_political_party
	* @param int $section
	*/
	public function addUnlike($id_political_party, $section)
	{
		return DB::update('update `section` SET `unlikes` = `likes` + 1 WHERE `id_political_party` = ? and `section` = ?', array($id_political_party, $section));
	}

	public function getComments($id_political_party, $section)
	{
		return DB::select('select `id_user`, `date`, `text` FROM `comment` WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));
	}

	public function getCommentsCount($id_political_party, $section)
	{
		return DB::select('select COUNT(*) FROM `comment` WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));
	}

	public function addComment()
	{
		$id_political_party = Input::get('id_political_party');
		$section = Input::get('section');
		$id_user = Input::get('id_user');
		$date = date('Y-m-d H:i:s');
		$text = Input::get('text');
		
		DB::insert('insert into `comment` (`id_political_party`, `section`, `id_user`, `date`, `text`) VALUES (?, ?, ?, ?, ?)', array($id_political_party, $section, $id_user, $date, $text));
	}

}