<?php

namespace App\Libraries;

use Google\Client;
use Google\Service\Oauth2;
use Google\Service\Blogger;
use Google\Service\PeopleService;
use Config\GoogleConfig;
use App\Models\AccessTokenModel;

class Google {
	private $client;
	private $config;
	private $userId;
	public function __construct($userId = 0) {
		// Initialize Googe Configs
		$this->config = new GoogleConfig();
		$this->accessTokenModel = new AccessTokenModel();

		// Initialize Google Client
		$this->client = new Client();
		$this->client->setClientId($this->config->clientId);
		$this->client->setClientSecret($this->config->clientSecret);
		$this->client->addScope(Blogger::BLOGGER);
		$this->client->addScope(PeopleService::USERINFO_PROFILE);
		$this->client->addScope(PeopleService::USER_GENDER_READ);
		$this->client->addScope(PeopleService::USERINFO_EMAIL);
		$this->client->setIncludeGrantedScopes(true);   // incremental auth
		$this->client->setAccessType('offline');       // offline access
		$this->client->setApprovalPrompt('force');
		$this->client->setPrompt('consent');

		if (php_sapi_name() !== 'cli') {
			$this->client->setRedirectUri(base_url("redirect/google"));
		}

		if ($userId != 0) {
			$this->userId = $userId;
			$record = $this->accessTokenModel->where('userid', $userId)->first();
			if (isset($record["token"])) {
				$accessToken = json_decode($record["token"], true);
				if (isset($accessToken["access_token"])) {
					$this->client->setAccessToken($accessToken);
					if ($this->client->isAccessTokenExpired()) {
						$this->refreshToken();
					}
				}
			}
		}
	}

	public function isAlive() {
		return $this->client->isAccessTokenExpired() ? false : true;
	}

	public function getAuthUrl() {
		return filter_var($this->client->createAuthUrl(), FILTER_SANITIZE_URL);
	}

	public function getAccessToken() {
		return $this->client->getAccessToken();
	}

	public function refreshToken() {
		$this->client->fetchAccessTokenWithRefreshToken();
		$updatedToken = $this->client->getAccessToken();
		if (isset($updatedToken["access_token"])) {
			$this->client->setAccessToken($updatedToken);
			if ($this->userId) {
				$this->accessTokenModel
					->where('userid', $this->userId)
					->set(["token" => json_encode($updatedToken), "isvalid" => TRUE])
					->update();
			}
			return $updatedToken;
		}
		return false;
	}

	public function setCode($code) {
		// Exchange authorization code for access token
		$token = $this->client->fetchAccessTokenWithAuthCode($code);
		if (isset($token["access_token"])) {
			$this->client->setAccessToken($token);
			return true;
		}
		return false;
	}

	public function getUser() {
		// Get user details using the access token
		$oauth2Service = new OAuth2($this->client);
		$userInfo = $oauth2Service->userinfo->get();
		// Get user details
		if ($userInfo && !empty($userInfo->getId()) && !empty($userInfo->getName()) && !empty($userInfo->getEmail())) {
			$gender = $userInfo->getGender() ?? 'Unknown';
			return [
				"gid" => $userInfo->getId(),
				"name" => $userInfo->getName(),
				"email" => $userInfo->getEmail(),
				"picture" => $userInfo->getPicture(),
				"gender" => $gender,
				"email_verified" => $userInfo->getVerifiedEmail(),
			];
		} else {
			return false;
		}
	}

	public function getBlogs() {
		$blogs = [];
		$blogger = new Blogger($this->client);
		$blogList = $blogger->blogs->listByUser('self');
		foreach ($blogList->getItems() as $blog) {
			array_push($blogs, [
				"gbid" => $blog->getId(),
				"name" => $blog->getName(),
				"url" => $blog->getUrl(),
			]);
		}
		return $blogs;
	}

	public function newPost($blogId, $content) {
		$blogger = new Blogger($this->client);
		$postObject = new Blogger\Post();
		$post = $this->setContent($postObject, ["title" => $content["slug"]]);
		$newPostObject = $blogger->posts->insert($blogId, $post);
		$postId = $newPostObject->getId();
		if ($postId) {
			$post = $this->setContent($newPostObject, $content);
			$newPost = $blogger->posts->update($blogId, $postId, $post);
			return (isset($newPost->url)) ? [
				"id" => $postId,
				"url" => $newPost->getUrl()
			] : FALSE;
		}
		return FALSE;
	}

	public function editPost($blogId, $postId, $content) {
		$blogger = new Blogger($this->client);
		$postObject = $blogger->posts->get($blogId, $postId);
		$post = $this->setContent($postObject, $content);
		$updatedPost = $blogger->posts->update($blogId, $postId, $post);
		return (isset($updatedPost->url)) ? $updatedPost : FALSE;
	}

	public function upload($blogId, $image) {
	}

	private function setContent($post, $content) {
		$post = new Blogger\Post();

		if (isset($content["title"]))
			$post->setTitle($content["title"]);

		if (isset($content["content"]))
			$post->setContent($content["content"]);


		if (isset($content["labels"]) && is_array($content["labels"]))
			$post->setLabels($content["labels"]);


		if (isset($content["summary"]))
			$post->setCustomMetaData($content["summary"]);


		if (isset($content["publish_at"]))
			$post->setPublished(date('c', strtotime($content["publish_at"])));


		if (isset($content["updated_at"]))
			$post->setUpdated(date('c', strtotime($content["updated_at"])));

		if (isset($content["author"])) {
			$author = new Blogger\PostAuthor();
			if (isset($content["author"]["name"]))
				$author->setDisplayName($content["author"]["name"]); // Name of author

			if (isset($content["author"]["id"]))
				$author->setId($content["author"]["id"]); // Optional: ID of the author, if available

			if (isset($content["author"]["url"]))
				$author->setId($content["author"]["url"]); // Optional: URL of the author's profile

			$post->setAuthor($author);
		}

		return $post;
	}
}
