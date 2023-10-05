<?php

namespace App\Controllers;

use App\Libraries\Google;

class Redirects extends BaseController {

    public function __construct() {
        $this->db = \Config\Database::connect();
        echo "<pre>";
    }

    public function google() {
        // Load Google API configuration
        $google = new Google();
        if ($this->request->getGet('code')) {
            $google->setCode($this->request->getGet('code'));

            if ($google->isAlive()) {
                $google->refreshToken();
                echo "Live now";
            } else {
                echo "Not live";
            }
        } else {
            if ($google->isAlive()) {
                return redirect()->to("");
            } else {
                return redirect()->to($google->getAuthUrl());
            }
        }
    }

    private function saveUserDetails($client) {
        
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
