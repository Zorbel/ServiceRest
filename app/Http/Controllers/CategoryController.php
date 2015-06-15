<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class CategoryController extends Controller {

	const SECTIONS_QUERY = 'SELECT `section`.`id_political_party`, `section`.`section`, `title`,
							(SELECT `name` FROM `category` WHERE `category`.`id` = `section`.`id_category`) AS `category`,
							`likes`, `not_understood`, `dislikes`, `views`, 
							(SELECT COUNT(*) FROM `comment` WHERE `section`.`id_political_party` = `comment`.`id_political_party` AND `section`.`section` = `comment`.`section`) AS `comments`
					   		FROM `section` 
					   		WHERE `id_category` = ';

	const PROPOSALS_QUERY = 'SELECT `id`, `title`, (SELECT `file` FROM `media` WHERE `proposal`.`id_image` = `media`.`id`) AS `id_image`, `views`, `likes`, `not_understood`, `dislikes`, `date`,
							(SELECT `nickname` FROM `user` WHERE `proposal`.`id_user` = `user`.`id`) AS `user`,
	 						(SELECT COUNT(*) FROM `comment` WHERE `comment`.`id_proposal` = `proposal`.`id`) AS `comments`
	 						FROM `proposal`
	 						WHERE `id_category` = ';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	public function getSections($id_category, $rows)
	{
		return DB::select(self::SECTIONS_QUERY . '? LIMIT 0, ?', array($id_category, $rows));
	}

	public function getProposals($id_category, $rows)
	{
		return DB::select(self::PROPOSALS_QUERY . '? LIMIT 0, ?', array($id_category, $rows));
	}

	public function getProposalsByOrder($id_category, $order, $rows)
	{
		switch ($order) {
			case "date":
				$results = DB::select(self::PROPOSALS_QUERY . '? ORDER BY `date` DESC LIMIT 0, ?', array($id_category, $rows));
				break;

			case "views":
				$results = DB::select(self::PROPOSALS_QUERY . '? ORDER BY `views` DESC LIMIT 0, ?', array($id_category, $rows));
				break;

			case "likes":
				$results = DB::select(self::PROPOSALS_QUERY . '? ORDER BY `likes` DESC LIMIT 0, ?', array($id_category, $rows));
				break;
				
			case "dislikes":
				$results = DB::select(self::PROPOSALS_QUERY . '? ORDER BY `dislikes` DESC LIMIT 0, ?', array($id_category, $rows));
				break;
							
			case "not_understood":
				$results = DB::select(self::PROPOSALS_QUERY . '? ORDER BY `not_understood` DESC LIMIT 0, ?', array($id_category, $rows));
				break;
			
			case "comments":
				$results = DB::select(self::PROPOSALS_QUERY . '? ORDER BY `comments` DESC LIMIT 0, ?', array($id_category, $rows));
				break;

			case "colaborative"
				$results = DB::select(self::PROPOSALS_QUERY . '? AND `id_wave` IS NOT NULL ORDER BY `date` DESC LIMIT 0, ?', array($id_category, $rows));
				
			default:
				return "Invalid parameter";
			}
			
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
