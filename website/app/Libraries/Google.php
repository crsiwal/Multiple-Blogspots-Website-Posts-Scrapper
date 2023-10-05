<?php

namespace App\Libraries;

use Google\Client;
use Config\GoogleConfig;
use Google\Service\Oauth2;
use Google\Service\Blogger;
use Google\Service\PeopleService;
use CodeIgniter\HTTP\RedirectResponse;
// use Google_Service_Blogger;

class Google {
	public $client;
	private $config;
	private $refreshToken;
	public function __construct($access_token = []) {
		// Initialize Googe Configs
		$this->config = new GoogleConfig();
		// Initialize Google Client
		$this->client = new Client();
		$this->client->setClientId($this->config->clientId);
		$this->client->setClientSecret($this->config->clientSecret);
		$this->client->addScope(Blogger::BLOGGER);
		$this->client->addScope(PeopleService::USERINFO_PROFILE);
		$this->client->addScope(PeopleService::USER_GENDER_READ);
		$this->client->addScope(PeopleService::USERINFO_EMAIL);
		$this->client->setRedirectUri(base_url("redirect/google"));
		$this->client->setAccessType('offline');
		// $this->client->setApprovalPrompt('force');
		if (isset($access_token["access_token"])) {
			$this->client->setAccessToken($access_token);
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
			return true;
		}
		return false;
	}

	public function setCode($code) {
		// Exchange authorization code for access token
		$token = $this->client->fetchAccessTokenWithAuthCode($code);
		if (!empty($token) && isset($token["access_token"])) {
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
}
