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
	}

	public function showCategory($id_category)
	{
		return DB::select('SELECT * FROM `proposal` WHERE `id_category` = ?', array($id_category));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$input = Request::only(`title`, `text`, `how`, `cost`, `id_category`, `id_user`, `id_image`, `id_wave`);

		if (is_null($input['title']) || is_null($input['text']) || is_null($input['how']) || is_null($input['cost']) || is_null($input['id_category']) || is_null($input['id_user']) || is_null($input['id_image']))
			return "Missing parameters";

		else
		{
			if (is_null($input['id_wave']))
			{
				if (DB::insert('INSERT INTO `proposal` (`title`, `text`, `id_category`, `id_image`, `date`, `id_user`, `id_wave`) VALUES (?, ?, ?, ?, ?, ?, ?)',
					array($input['title'], $input['text'], $input['how'], $input['cost'], $input['id_category'], $input['id_image'], date('Y-m-d H:i:s'), $input['id_user']), $input['id_wave']))
					return "ok";
					//return ProposalController::show(DB::getPdo()->lastInsertId());
				else
					return "Error unexpected";
			}

			else
			{
				if (DB::insert('INSERT INTO `proposal` (`title`, `text`, `how`, `cost`, `id_category`, `id_image`, `date`, `id_user`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
					array($input['title'], $input['text'], $input['how'], $input['cost'], $input['id_category'], $input['id_image'], date('Y-m-d H:i:s'), $input['id_user'])))
					return "Ok";
					//return ProposalController::show(DB::getPdo()->lastInsertId());
				else
					return "Error unexpected";
			}
		}
	}

	public function showUserProposals($id)
	{
		return DB::select('SELECT `id`, `title`, (SELECT `file` FROM `media` WHERE `proposal`.`id_image` = `media`.`id`) AS `id_image`, `views`, `likes`, `not_understood`, `dislikes`, `date`,
							(SELECT `nickname` FROM `user` WHERE `proposal`.`id_user` = `user`.`id`) AS `user`,
	 						(SELECT COUNT(*) FROM `comment` WHERE `comment`.`id_proposal` = `proposal`.`id`) AS `comments`
	 						FROM `proposal`
	 						WHERE `id_user` = ? AND `id_wave` IS NULL
	 						ORDER BY `date` DESC', array($id));
	}

	public function showUserColaborativeProposals($id)
	{
		return DB::select('SELECT `id`, `title`, (SELECT `file` FROM `media` WHERE `proposal`.`id_image` = `media`.`id`) AS `id_image`, `views`, `likes`, `not_understood`, `dislikes`, `date`,
					(SELECT `nickname` FROM `user` WHERE `proposal`.`id_user` = `user`.`id`) AS `user`,
						(SELECT COUNT(*) FROM `comment` WHERE `comment`.`id_proposal` = `proposal`.`id`) AS `comments`
						FROM `proposal`
						WHERE `id_user` = ? AND `id_wave` IS NOT NULL
						ORDER BY `date` DESC', array($id));
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
		DB::update('UPDATE `proposal` SET `views` = `views` + 1 WHERE `id` = ?', array($id));

		$results = DB::select('SELECT `id`, `title`, `text`, `how`, `cost`,
							(SELECT `file` FROM `media` WHERE `proposal`.`id_image` = `media`.`id`) AS `image`, `date`,
							(SELECT `name` FROM `category` WHERE `proposal`.`id_category` = `category`.`id`) AS `category`,
							(SELECT `nickname` FROM `user` WHERE `proposal`.`id_user`= `user`.`id`) AS `user`,
							`views`, `likes`, `not_understood`, `dislikes`, 
							(SELECT COUNT(*) FROM `comment` WHERE `proposal`.`id` = `comment`.`id_proposal`) AS `comments`, `id_wave`
							FROM `proposal` WHERE `proposal`.`id` = ?', array($id));

		if (is_null($results[0]->id_wave))
			$results[0]->id_wave = "";

		return $results;
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

	public function getOpinion()
	{
		$input = Request::only(`id_user`, `id_proposal`, `opinion`);

		$result = DB::select('SELECT * FROM `opinion` WHERE `id_user` = ? AND `id_proposal` = ?', 
			array($input['id_user'], $input['id_proposal']));

		switch ($input['opinion']) {
			case "like":
				if (empty($result))
				{
					DB::insert('INSERT INTO `opinion`(`id_user`, `id_proposal`, `opinion`) VALUES (?, ?, ?)', 
						array($input['id_user'], $input['id_proposal'], $input['opinion']));
					return ProposalController::addLike($input['id_proposal']);
				}
				else
				{
					DB::delete('DELETE FROM `opinion` WHERE `id_user` = ? AND `id_proposal` = ?', 
						array($input['id_user'], $input['id_proposal']));
					return ProposalController::delLike($input['id_proposal']);
				}
				break;

			case "dislike":
				if (empty($result))
				{
					DB::insert('INSERT INTO `opinion`(`id_user`, `id_proposal`, `opinion`) VALUES (?, ?, ?)', 
						array($input['id_user'], $input['id_proposal'], $input['opinion']));
					return ProposalController::addDislike($input['id_proposal']);
				}
				else
				{
					DB::delete('DELETE FROM `opinion` WHERE `id_user` = ? AND `id_proposal` = ?', 
						array($input['id_user'], $input['id_proposal']));
					return ProposalController::delLike($input['id_proposal']);
				}
				break;
			
			case "not_understood":
				if (empty($result))
				{
					DB::insert('INSERT INTO `opinion`(`id_user`, `id_proposal`, `opinion`) VALUES (?, ?, ?)', 
						array($input['id_user'], $input['id_proposal'], $input['opinion']));
					return ProposalController::addNotUnderstood($input['id_proposal']);
				}
				else
				{
					DB::delete('DELETE FROM `opinion` WHERE `id_user` = ? AND `id_proposal` = ?', 
						array($input['id_user'], $input['id_proposal']));
					return ProposalController::delNotUnderstood($input['id_proposal']);
				}
				break;

			default:
				# code...
				break;
		}
	}

	public function getLikes($id_proposal)
	{
		return DB::select('select `likes` FROM `proposal` WHERE `id` = ?', array($id_proposal));
	}

	/**
	*/
	private function addLike($id_proposal)
	{
		DB::update('update `proposal` SET `likes` = `likes` + 1 WHERE `id` = ?', array($id_proposal));
		return ProposalController::getCounters($id_proposal);
	}

	private function delLike($id_proposal)
	{
		DB::update('update `proposal` SET `likes` = `likes` - 1 WHERE `id` = ?', array($id_proposal));
		return ProposalController::getCounters($id_proposal);
	}

	/**
	*/
	public function getDislikes($id_proposal)
	{
		return DB::select('select `dislikes` FROM `proposal` WHERE `id` = ?', array($id_proposal));
	}

	/**
	*/
	private function addDislike($id_proposal)
	{
		DB::update('update `proposal` SET `dislikes` = `dislikes` + 1 WHERE `id` = ?', array($id_proposal));
		return ProposalController::getCounters($id_proposal);
	}

	private function delDislike($id_proposal)
	{
		DB::update('update `proposal` SET `dislikes` = `dislikes` - 1 WHERE `id` = ?', array($id_proposal));
		return ProposalController::getCounters($id_proposal);
	}

	/**
	*/
	public function getNotUnderstoods($id_proposal)
	{
		return DB::select('select `not_understood` FROM `proposal` WHERE `id` = ?', array($id_proposal));
	}

	/**
	*/
	private function addNotUnderstood($id_proposal)
	{
		DB::update('update `proposal` SET `not_understood` = `not_understood` + 1 WHERE `id` = ?', array($id_proposal));
		return ProposalController::getCounters($id_proposal);
	}

	private function delNotUnderstood($id_proposal)
	{
		DB::update('update `proposal` SET `not_understood` = `not_understood` - 1 WHERE `id` = ?', array($id_proposal));
		return ProposalController::getCounters($id_proposal);
	}

	/**
	*/
	private function getCounters($id_proposal)
	{
		return DB::select('SELECT `likes`, `not_understood`, `dislikes`, `views`, 
							(SELECT COUNT(*) FROM `comment` WHERE `id_proposal` = ?) AS `comments` 
							FROM `proposal` WHERE `id` = ?', array($id_proposal, $id_proposal));		
	}
}