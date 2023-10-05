<?php

namespace App\Controllers;



use Config\Google;
use CodeIgniter\HTTP\RedirectResponse;

class Redirects extends BaseController {

    public function __construct() {
        $this->db = \Config\Database::connect();
        echo "<pre>";
    }


    public function googleS() {
        // Load Google API configuration
        $config = new Google();

        // Initialize Google Client
        $client = new Google_Client();
        $client->setClientId($config->clientId);
        $client->setClientSecret($config->clientSecret);
        $client->addScope(Blogger::BLOGGER);
        $client->addScope(PeopleService::USERINFO_PROFILE);
        $client->addScope(PeopleService::USER_GENDER_READ);
        $client->addScope(PeopleService::USERINFO_EMAIL);
        $client->setRedirectUri(base_url("redirect/google"));
        $auth_url = $client->createAuthUrl();
        if ($this->request->getGet('code')) {
            // Exchange authorization code for access token
            $client->authenticate($this->request->getGet('code'));
            $access_token = $client->getAccessToken();
            $this->saveUserDetails($client);
            $this->saveUserBlogs($client);
            vd($access_token);
            return "";
        } else {
            return redirect()->to(filter_var($auth_url, FILTER_SANITIZE_URL));
        }
    }


    private function saveUserDetails($client) {
        // Get user details using the access token
        $oauth2Service = new OAuth2($client);
        $userInfo = $oauth2Service->userinfo->get();

        // Now you can access user details
        $userId = $userInfo->getId();
        $userName = $userInfo->getName();
        $userEmail = $userInfo->getEmail();
        $userProfilePicture = $userInfo->getPicture();
        $verifiedEmail = $userInfo->getVerifiedEmail();
        $gender = $userInfo->getGender();
        var_dump($userId,  $userName, $userEmail, $userProfilePicture, $verifiedEmail, $gender);
    }

    private function saveUserBlogs($client) {
        $blogger = new Google_Service_Blogger($client);
        $blogs = $blogger->blogs->listByUser('self');

        // Iterate through the list of blogs and handle them as needed
        foreach ($blogs->getItems() as $blog) {
            $blogId = $blog->getId();
            $blogTitle = $blog->getName();
            $blogURL = $blog->getUrl();
            var_dump($blogId, $blogTitle, $blogURL);
        }
    }
}
