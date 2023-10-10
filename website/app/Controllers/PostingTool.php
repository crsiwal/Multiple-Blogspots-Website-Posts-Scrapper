<?php
/*
	Syntax: php public/index.php tools batchpost
*/

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\CLI\CLI;
use App\Libraries\Google;
use App\Models\AccessTokenModel;
use App\Models\BloggerModel;
use App\Models\UserModel;
use App\Models\BlogsModel;
use App\Models\PostsModel;

class PostingTool extends Controller {

	public function __construct() {
		$this->blogModel = new BlogsModel();
		$this->postModel = new PostsModel();
		$this->db = \Config\Database::connect();
		$this->maxPosts = 1;
	}

	public function post() {
		$postsModel = new PostsModel();
		$posts = $postsModel->where([
			"post_at <= " => date('Y-m-d H:i:s'),
			"status" => 4 // Scheduled
		])->limit($this->maxPosts)->orderBy("post_at", "ASC")->find();
		if (is_array($posts) && count($posts) > 0) {
			$accessTokenModel = new AccessTokenModel();
			$activeUser = 0;
			$google = "";
			$accessToken = "";
			foreach ($posts as $post) {
				if ($activeUser != $post["userid"]) {
					$google = new Google($post["userid"]);
				}
				$blogId = "1017300391299230992";
				$blogPost = $google->newPost($blogId, [
					"title" => $post["title"],
					"slug" => $post["slug"],
					"summary" => $post["summary"],
					"content" => $post["content"],
					"labels" => explode(",", $post["tags"]),
					"author" => ["name" => "Data Center"]
				]);
				if (isset($blogPost["id"])) {
					$postsModel->update($post["id"], [
						"status" => 5, // Posted
						"posted_at" => date('Y-m-d H:i:s')
					]);
				}
			}
		}
	}
}
