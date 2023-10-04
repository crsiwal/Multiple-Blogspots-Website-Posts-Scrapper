<?php
/*
Syntax: php public/index.php tools crawler
*/

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\CLI\CLI;
use App\Models\BlogsModel;
use App\Models\PostsModel;

class BlogsTool extends Controller {

	public function __construct() {
		$this->blogModel = new BlogsModel();
		$this->postModel = new PostsModel();
		$this->db = \Config\Database::connect();
		$this->maxBlogPost = 20;
	}

	public function crawler() {
		CLI::write("Crawling Started....", "cyan");
		$blogs = $this->blogModel
			->where("posts <>", "scraped", false)
			->where("active", true)
			->findAll(5);
		if (is_array($blogs) && count($blogs) > 0) {
			foreach ($blogs as $blog) {
				CLI::write("Fetching for " . $blog["url"], "cyan");
				CLI::write($blog["title"], "cyan");
				CLI::write("Posts: " . $blog["posts"], "cyan");
				CLI::write("Blogger Id: " . $blog["gbid"], "cyan");
				CLI::write("Post Scraped: " . $blog["scraped"], "cyan");
				$this->fetch_blog_data($blog, 50);
			}
		}
	}

	private function fetch_blog_data($blog, $once_limit = 5) {
		$i = 0;
		while ($blog["posts"] > $blog["scraped"]) {
			$blog_data = $this->_blog_data($blog["url"], $once_limit, $blog["scraped"] + 1);
			if (isset($blog_data["posts"]) && is_array($blog_data["posts"]) && count($blog_data["posts"]) > 0) {
				foreach ($blog_data["posts"] as $post) {
					$post_id = $this->store_post($blog["id"], $post);
					if ($post_id) {
						CLI::write((++$i) . " Post Scraped BlogId:" . $blog["id"] . " -- Post Number: " . ($blog["scraped"] + 1), 'green');
						$this->db->table('blogs')->set("scraped", "scraped + 1", false)->where("id", $blog["id"])->update();
					}
					$blog["scraped"]++;
				}
			}
			if ($i < $this->maxBlogPost) {
				CLI::write("Waiting for next run....", 'purple');
				sleep(1);
			} else {
				break;
			}
		}
	}

	private function store_post($blogid, $post) {
		if ($this->postModel->select('id')->where(["blogid" => $blogid, 'postgid' => $post["numid"]])->get()->getNumRows() == 0) {
			$data = [
				"blogid" => $blogid,
				"postgid" => $post["numid"],
				"sourceurl" => isset($post["links"]["alternate"]) ? $post["links"]["alternate"] : "unknown",
				"title" => $post["title"],
				"slug" => isset($post["links"]["alternate"]) ? $this->find_slug($post["links"]["alternate"]) : $this->create_slug($post["title"]),
				"content" => $this->remove_css($post["content"]),
				"tags" => implode(",", $post["category"]),
				"status" => 1,
			];
			return $this->postModel->insert($data);
		}
		return FALSE;
	}

	private function create_slug($title) {
		// Convert the title to lowercase
		$slug = strtolower($title);

		// Remove special characters and spaces, replace them with hyphens
		$slug = preg_replace('/[^a-z0-9]+/', '-', $slug);

		// Remove leading and trailing hyphens
		$slug = trim($slug, '-');

		return $slug;
	}

	private function find_slug($url) {
		// Parse the URL to get the path
		$path = parse_url($url, PHP_URL_PATH);

		// Explode the path using '/' as the delimiter
		$pathParts = explode('/', $path);

		if (isset($pathParts[3])) {
			$areaWithExtension = $pathParts[3];
			return preg_replace('/\.html$/', '', $areaWithExtension); // Remove ".html" extension and return value
		}
		return FALSE;
	}

	private function remove_css($html) {
		// Remove <style> elements
		$html = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $html);

		// Remove inline style attributes
		$html = preg_replace('/\sstyle=("|\')(.*?)("|\')/i', '', $html);

		return $html;
	}

	private function _blog_data($blog_url, $max = 25, $start_from = 1) {
		CLI::write("Getting data from remote url start-index: " . $start_from . " max-results: " . $max, "yellow");
		try {
			$client = \Config\Services::curlrequest([
				'baseURI' => $blog_url,
			]);
			$response = $client->get("feeds/posts/default", [
				'timeout' => 30,
				'query' => [
					'alt' => 'json',
					'max-results' => $max,
					'start-index' => ($start_from < 1) ? 1 : $start_from,
				]
			]);
			if ($response->getStatusCode() == 200) {
				$blog = [];
				$data = json_decode($response->getBody());
				$t = '$t';
				$ost = 'openSearch$totalResults';
				$linklist = ["self", "alternate", "next"];
				if (isset($data->feed->id->$t)) {
					$blog["id"] = $data->feed->id->$t;
					$blog["gbid"] = preg_match('/blog-(\d+)/', $data->feed->id->$t, $matches) ? (isset($matches[1]) ? $matches[1] : "") : "";
					$blog["title"] = isset($data->feed->title->$t) ? $data->feed->title->$t : "";
					$blog["subtitle"] = isset($data->feed->subtitle->$t) ? $data->feed->subtitle->$t : "";
					$blog["category"] = isset($data->feed->category) ? array_column($data->feed->category, "term") : [];
					$blog["links"] = isset($data->feed->link) ? array_filter(
						array_column($data->feed->link, "href", "rel"),
						function ($key) use ($linklist) {
							return in_array($key, $linklist);
						},
						ARRAY_FILTER_USE_KEY
					) : [];
					$blog["total"] = isset($data->feed->$ost->$t) ? $data->feed->$ost->$t : 0;
					$blog["posts"] = [];
					if (isset($data->feed->entry) && count($data->feed->entry) > 0) {
						foreach ($data->feed->entry as $i => $post) {
							if ($i == 3) {
								$blog["contentallowed"] = isset($post->content->$t) ? true : false;
							}
							$single = [
								"id" => $post->id->$t,
								"numid" => preg_match('/post-(\d+)/', $post->id->$t, $matches) ? (isset($matches[1]) ? $matches[1] : "") : "",
								"category" => isset($post->category) ? array_column($post->category, "term") : [],
								"title" => $post->title->$t,
								"content" => isset($post->content->$t) ? $post->content->$t : (isset($post->summary->$t) ? $post->summary->$t : FALSE),
								"links" => array_filter(
									array_column($post->link, "href", "rel"),
									function ($key) use ($linklist) {
										return in_array($key, $linklist);
									},
									ARRAY_FILTER_USE_KEY
								),
							];
							array_push($blog["posts"], $single);
						}
					}
					return $blog;
				}
			}
			return FALSE;
		} catch (Exception $e) {
			CLI::error('Error: ' . $e->getMessage());
			return FALSE;
		}
	}
}
