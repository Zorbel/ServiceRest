<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class TopController extends Controller {

	const SECTIONS_QUERY = 'SELECT `section`.`id_political_party`, `section`.`section`, `title`,
							(SELECT `name` FROM `category` WHERE `category`.`id` = `section`.`id_category`) AS `category`,
							`likes`, `not_understood`, `dislikes`, `views`, 
							(SELECT COUNT(*) FROM `comment` WHERE `section`.`id_political_party` = `comment`.`id_political_party` AND `section`.`section` = `comment`.`section`) AS `comments`
					   		FROM `section` 
					   		ORDER BY ';

	const PROPOSALS_QUERY = 'SELECT `id`, `title`, (SELECT `file` FROM `media` WHERE `proposal`.`id_image` = `media`.`id`) AS `id_image`, `views`, `likes`, `not_understood`, `dislikes`, `date`,
							(SELECT `nickname` FROM `user` WHERE `proposal`.`id_user` = `user`.`id`) AS `user`,
	 						(SELECT COUNT(*) FROM `comment` WHERE `comment`.`id_proposal` = `proposal`.`id`) AS `comments`
	 						FROM `proposal`
	 						ORDER BY ';

	const COMPARATIVES_QUERY = 	'SELECT `id`, `title`, `image`, `date`, `views`, `likes`, `not_understood`, `dislikes`,
	 							(SELECT COUNT(*) FROM `comment` WHERE `comment`.`id_comparative` = `comparative`.`id`) AS `comments`
	 							FROM `comparative`
	 							ORDER BY ';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$last_proposals = DB::select(self::PROPOSALS_QUERY . '`date` DESC LIMIT 0, 3');
		$popular_sections = DB::select(self::SECTIONS_QUERY . '`views` DESC LIMIT 0, 3');
		$sections_more_comments = DB::select(self::SECTIONS_QUERY . '`comments` DESC LIMIT 0, 3');

		return array("last_proposals" => $last_proposals, "popular_sections" => $popular_sections, "sections_more_comments" => $sections_more_comments);
	}

	public function top3Secions()
	{
		$views = DB::select(self::SECTIONS_QUERY . '`views` DESC LIMIT 0, 3');
		$likes = DB::select(self::SECTIONS_QUERY . '`likes` DESC LIMIT 0, 3');
		$dislikes = DB::select(self::SECTIONS_QUERY . '`dislikes` DESC LIMIT 0, 3');
		$not_understood = DB::select(self::SECTIONS_QUERY . '`not_understood` DESC LIMIT 0, 3');
 		$comments = DB::select(self::SECTIONS_QUERY . '`comments` DESC LIMIT 0, 3');

		return array("top_views" => $views, "top_likes" => $likes, "top_dislikes" => $dislikes, "top_not_understood" => $not_understood, "top_comments" => $comments);
	}

	public function top10Sections($resource, $rows)
	{
		switch ($resource) {
			case "views":
				return DB::select(self::SECTIONS_QUERY . '`views` DESC LIMIT 0, ?', array($rows));

			case "likes":
				return DB::select(self::SECTIONS_QUERY . '`likes` DESC LIMIT 0, ?', array($rows));
				
			case "dislikes":
				return DB::select(self::SECTIONS_QUERY . '`dislikes` DESC LIMIT 0, ?', array($rows));
							
			case "not_understood":
				return DB::select(self::SECTIONS_QUERY . '`not_understood` DESC LIMIT 0, ?', array($rows));
				
			case "comments":
				return DB::select(self::SECTIONS_QUERY . '`comments` DESC LIMIT 0, ?', array($rows));
				
			default:
				return "Invalid parameter";
		}
	}

	public function top10Proposals($resource, $rows)
	{
		switch ($resource) {
			case "date":
				$results = DB::select(self::PROPOSALS_QUERY . '`date` DESC LIMIT 0, ?', array($rows));
				break;

			case "views":
				$results = DB::select(self::PROPOSALS_QUERY . '`views` DESC LIMIT 0, ?', array($rows));
				break;

			case "likes":
				$results = DB::select(self::PROPOSALS_QUERY . '`likes` DESC LIMIT 0, ?', array($rows));
				break;
				
			case "dislikes":
				$results = DB::select(self::PROPOSALS_QUERY . '`dislikes` DESC LIMIT 0, ?', array($rows));
				break;
							
			case "not_understood":
				$results = DB::select(self::PROPOSALS_QUERY . '`not_understood` DESC LIMIT 0, ?', array($rows));
				break;
			
			case "comments":
				$results = DB::select(self::PROPOSALS_QUERY . '`comments` DESC LIMIT 0, ?', array($rows));
				break;
				
			default:
				return "Invalid parameter";
			}

		/*
		$i = 0;

		foreach ($results as $value) {
			$list[$i] = array("id" => $value->id, "title" => $value->title, "image" => base64_encode($value->image), "date" => $value->date, "views" => $value->date,
			 "likes" => $value->likes, "not_understood" => $value->not_understood, "dislikes" => $value->dislikes);
			$i++;
		}
		*/

		return $results;
	}

	public function top10Comparatives($resource, $rows)
	{
		switch ($resource) {
			case "views":
				$results = DB::select(self::COMPARATIVES_QUERY . '`views` DESC LIMIT 0, ?', array($rows));
				break;

			case "likes":
				$results = DB::select(self::COMPARATIVES_QUERY . '`likes` DESC LIMIT 0, ?', array($rows));
				break;
				
			case "dislikes":
				$results = DB::select(self::COMPARATIVES_QUERY . '`dislikes` DESC LIMIT 0, ?', array($rows));
				break;
							
			case "not_understood":
				$results = DB::select(self::COMPARATIVES_QUERY . '`not_understood` DESC LIMIT 0, ?', array($rows));
				break;
			
			case "comments":
				$results = DB::select(self::COMPARATIVES_QUERY . '`comments` DESC LIMIT 0, ?', array($rows));
				break;
				
			default:
				return "Invalid parameter";
			}

		$i = 0;

		foreach ($results as $value) {
			$list[$i] = array("id" => $value->id, "title" => $value->title, "image" => base64_encode($value->image), "date" => $value->date, "views" => $value->date,
			 "likes" => $value->likes, "not_understood" => $value->not_understood, "dislikes" => $value->dislikes);
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