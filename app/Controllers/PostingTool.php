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
use App\Models\BloggerpostsModel;
use App\Models\UserModel;
use App\Models\BlogsModel;
use App\Models\PostsModel;

class PostingTool extends Controller {

	public function __construct() {
		$this->blogModel = new BlogsModel();
		$this->postModel = new PostsModel();
		$this->bloggerPostModel = new BloggerpostsModel();
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
			$activeUser = 0;
			$google = "";
			foreach ($posts as $post) {
				if ($activeUser != $post["userid"]) {
					$google = new Google($post["userid"]);
					$activeUser = $post["userid"];
				}

				/* Get the list of blogger where to post these blogs */
				$builder = $this->db->table('bloggerposts as a');
				$builder->select('a.*, b.gbid');
				$builder->join('bloggers as b', 'b.id = a.bloggerid');
				$builder->where('a.postid', $post["id"]);
				$bloggers = $builder->get()->getResultArray();
				if (count($bloggers) > 0) {
					foreach ($bloggers as $blogger) {
						$blogPost = $google->newPost($blogger["gbid"], [
							"title" => $post["title"],
							"slug" => $post["slug"],
							"summary" => $post["summary"],
							"content" => $post["content"],
							"labels" => explode(",", $post["tags"]),
							"author" => ["name" => "Data Center"]
						]);
						if (isset($blogPost["id"])) {
							$postsModel->update($post["id"], ["status" => 5, "posted_at" => date('Y-m-d H:i:s')]); // Posted
							$this->db->table('blogs')->set("posted", "posted + 1", false)->where("id", $post["blogid"])->update();
						}
					}
				}
			}
		}
	}
}
