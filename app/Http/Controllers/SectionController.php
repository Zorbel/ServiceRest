<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB; // Need for DB calls
//use Illuminate\Http\Request;
use Request;

class SectionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id_political_party)
	{
		return DB::select('SELECT * FROM `section` WHERE `id_political_party` = ?', array($id_political_party));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return DB::create('');
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
		$input = Request::only(`id_user`);

		$result1 = DB::select('SELECT `section`, `title`, `text`, `likes`, `not_understood`, `dislikes`,
		 (SELECT `id_user` FROM `favorites` WHERE `id_user` = ? AND `id_political_party` = ? AND `section` = ?) AS `favorite`
			FROM `section` WHERE `id_political_party` = ? AND `section` = ?', array($input['id_user'], $id_political_party, $section, $id_political_party, $section));

		if (is_null($result1[0]->favorite))
			$result1[0]->favorite = "no";
		else
			$result1[0]->favorite = "yes";

		if (is_null($result1[0]->text))
			$result1[0]->text = "";
		else
			DB::update('UPDATE `section` SET `views` = `views` + 1 WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));

		$result2 = DB::select('SELECT COUNT(*) AS `comments` FROM `comment` WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));

		return array("section" => $result1[0]->section, 
					 "title" => $result1[0]->title, 
					 "text" => $result1[0]->text, 
					 "likes" => $result1[0]->likes, 
					 "not_understood" => $result1[0]->not_understood, 
					 "dislikes" => $result1[0]->dislikes, 
					 "comments" => $result2[0]->comments,
					 "favorite" => $result1[0]->favorite);
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

	private function newOpinion($id_political_party, $section, $opinion)
	{
		switch ($opinion) {
			case "like":
				SectionController::addLike($id_political_party, $section);
				break;

			case "dislike":
				SectionController::addDislike($id_political_party, $section);
				break;

			case "not_understood":
				SectionController::addNotUnderstood($id_political_party, $section);
				break;
			
			default:
				# code...
				break;
		}
	}

	private function delOldOpinion($id_political_party, $section, $opinion)
	{
		switch ($opinion) {
			case "like":
				SectionController::delLike($id_political_party, $section);
				break;

			case "dislike":
				SectionController::delDislike($id_political_party, $section);
				break;

			case "not_understood":
				SectionController::delNotUnderstood($id_political_party, $section);
				break;
			
			default:
				# code...
				break;
		}
	}

	public function setOpinion()
	{
		$input = Request::only(`id_user`, `id_political_party`, `section`, `opinion`);

		$result = DB::select('SELECT * FROM `opinion` WHERE `id_user` = ? AND `id_political_party` = ? AND `section` = ?', 
			array($input['id_user'], $input['id_political_party'], $input['section']));

		switch ($input['opinion']) {
			case "like":
				if (empty($result))
				{
					DB::insert('INSERT INTO `opinion` (`id_user`, `id_political_party`, `section`, `opinion`) VALUES (?, ?, ?, ?)', 
						array($input['id_user'], $input['id_political_party'], $input['section'], $input['opinion']));
					SectionController::addLike($input['id_political_party'], $input['section']);
				}
				else
				{
					DB::delete('DELETE FROM `opinion` WHERE `id_user` = ? AND `id_political_party` = ? AND `section` = ?', 
						array($input['id_user'], $input['id_political_party'], $input['section']));
					SectionController::delOldOpinion($result[0]->id_political_party, $result[0]->section, $result[0]->opinion);
					
					if (strcmp($result[0]->opinion, "like") !== 0)
					{
						DB::insert('INSERT INTO `opinion` (`id_user`, `id_political_party`, `section`, `opinion`) VALUES (?, ?, ?, ?)', 
							array($input['id_user'], $input['id_political_party'], $input['section'], $input['opinion']));
						SectionController::newOpinion($input['id_political_party'], $input['section'], $input['opinion']);
					}

				}
				return SectionController::getCounters($input['id_political_party'], $input['section']);				
				break;

			case "dislike":
				if (empty($result))
				{
					DB::insert('INSERT INTO `opinion` (`id_user`, `id_political_party`, `section`, `opinion`) VALUES (?, ?, ?, ?)', 
						array($input['id_user'], $input['id_political_party'], $input['section'], $input['opinion']));
					SectionController::addDislike($input['id_political_party'], $input['section']);
				}
				else
				{
					DB::delete('DELETE FROM `opinion` WHERE `id_user` = ? AND `id_political_party` = ? AND `section` = ?', 
						array($input['id_user'], $input['id_political_party'], $input['section']));
					SectionController::delOldOpinion($result[0]->id_political_party, $result[0]->section, $result[0]->opinion);

					if (strcmp($result[0]->opinion, "dislike") !== 0)
					{
						DB::insert('INSERT INTO `opinion` (`id_user`, `id_political_party`, `section`, `opinion`) VALUES (?, ?, ?, ?)', 
							array($input['id_user'], $input['id_political_party'], $input['section'], $input['opinion']));
						SectionController::newOpinion($input['id_political_party'], $input['section'], $input['opinion']);
					}

				}
				return SectionController::getCounters($input['id_political_party'], $input['section']);
				break;
			
			case "not_understood":
				if (empty($result))
				{
					DB::insert('INSERT INTO `opinion` (`id_user`, `id_political_party`, `section`, `opinion`) VALUES (?, ?, ?, ?)', 
						array($input['id_user'], $input['id_political_party'], $input['section'], $input['opinion']));
					SectionController::addNotUnderstood($input['id_political_party'], $input['section']);
				}
				else
				{
					DB::delete('DELETE FROM `opinion` WHERE `id_user` = ? AND `id_political_party` = ? AND `section` = ?', 
						array($input['id_user'], $input['id_political_party'], $input['section']));
					SectionController::delOldOpinion($result[0]->id_political_party, $result[0]->section, $result[0]->opinion);					

					if (strcmp($result[0]->opinion, "not_understood") !== 0)
					{
						DB::insert('INSERT INTO `opinion` (`id_user`, `id_political_party`, `section`, `opinion`) VALUES (?, ?, ?, ?)', 
							array($input['id_user'], $input['id_political_party'], $input['section'], $input['opinion']));
						SectionController::newOpinion($input['id_political_party'], $input['section'], $input['opinion']);
					}

				}
				return SectionController::getCounters($input['id_political_party'], $input['section']);
				break;

			default:
				# code...
				break;
		}
	}

	/**
	*/
	public function getLikes($id_political_party, $section)
	{
		return DB::select('SELECT `likes` FROM `section` WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));
	}

	/**
	*/
	private function addLike($id_political_party, $section)
	{
		DB::update('UPDATE `section` SET `likes` = `likes` + 1 WHERE `id_political_party` = ? and `section` = ?', array($id_political_party, $section));
	}

	private function delLike($id_political_party, $section)
	{
		DB::update('UPDATE `section` SET `likes` = `likes` - 1 WHERE `id_political_party` = ? and `section` = ?', array($id_political_party, $section));
	}

	/**
	*/
	public function getDislikes($id_political_party, $section)
	{
		return DB::select('SELECT `dislikes` FROM `section` WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));
	}

	/**
	*/
	private function addDislike($id_political_party, $section)
	{
		DB::update('UPDATE `section` SET `dislikes` = `dislikes` + 1 WHERE `id_political_party` = ? and `section` = ?', array($id_political_party, $section));
	}

	private function delDislike($id_political_party, $section)
	{
		DB::update('UPDATE `section` SET `dislikes` = `dislikes` - 1 WHERE `id_political_party` = ? and `section` = ?', array($id_political_party, $section));
	}

	/**
	*/
	public function getNotUnderstoods($id_political_party, $section)
	{
		return DB::select('SELECT `not_understood` FROM `section` WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section));
	}

	/**
	*/
	private function addNotUnderstood($id_political_party, $section)
	{
		DB::update('UPDATE `section` SET `not_understood` = `not_understood` + 1 WHERE `id_political_party` = ? and `section` = ?', array($id_political_party, $section));
	}

	private function delNotUnderstood($id_political_party, $section)
	{
		DB::update('UPDATE `section` SET `not_understood` = `not_understood` - 1 WHERE `id_political_party` = ? and `section` = ?', array($id_political_party, $section));
	}

	/**
	*/
	private function getCounters($id_political_party, $section)
	{
		return DB::select('SELECT `likes`, `not_understood`, `dislikes`, `views`, (SELECT COUNT(*) FROM `comment` WHERE `id_political_party` = ? AND `section` = ?) AS `comments` 
					   	   FROM `section` WHERE `id_political_party` = ? AND `section` = ?', array($id_political_party, $section, $id_political_party, $section));		
	}

}
