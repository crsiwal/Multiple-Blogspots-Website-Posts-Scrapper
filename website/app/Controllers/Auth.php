<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\Google;
use App\Models\AccessTokenModel;
use App\Models\BloggerModel;
use App\Models\UserModel;

class Auth extends Controller {

    public function login() {
        echo anchor("redirect/google", "Login Now");
    }

    public function google() {
        if (!is_login()) {
            // Load Google API configuration
            $google = new Google();
            if ($this->request->getGet('code')) {
                if ($google->setCode($this->request->getGet('code'))) {
                    $user = $google->getUser();
                    $userid = $this->getUserId($user);
                    if ($userid) {
                        login_user($userid);
                        $this->storeAccessToken($userid, $google->getAccessToken());
                        $blogs = $google->getBlogs();
                        $this->storeBlogs($userid, $blogs);
                        return redirect()->to("");
                    }
                }
                return redirect()->to("login");
            } else {
                return redirect()->to($google->getAuthUrl());
            }
        } else {
            return redirect()->to("");
        }
    }

    public function logout() {
        logout();
        return redirect()->to("login");
    }

    private function getUserId($guser) {
        if (isset($guser["gid"])) {
            $userModel = new UserModel();
            $user = $userModel->where('gid', $guser["gid"])->first();
            if (isset($user["id"])) {
                return $user["id"];
            } else {
                return $userModel->insert([
                    "gid" => $guser["gid"],
                    "name" => $guser["name"],
                    "email" => $guser["email"],
                    "vemail" => $guser["email_verified"],
                    "picture" => $guser["picture"],
                    "gender" => $guser["gender"],
                    "password" => "NOTSET",
                    "salt" => "NOTSET",
                    "status" => 1, // Active
                ]);
            }
        }
        return false;
    }

    private function storeAccessToken($userid, $token) {
        if (isset($token["access_token"])) {
            $accessTokenModel = new AccessTokenModel();
            $record = $accessTokenModel->where('userid', $userid)->first();
            if (isset($record["id"])) {
                $update = $accessTokenModel->update($record["id"], [
                    "token" => json_encode($token),
                    "isvalid" => TRUE,
                ]);
                return $update ? $record["id"] : FALSE;
            } else {
                return $accessTokenModel->insert([
                    "userid" => $userid,
                    "token" => json_encode($token),
                    "isvalid" => TRUE,
                ]);
            }
        }
        return false;
    }

    private function storeBlogs($userid, $blogs) {
        if (is_array($blogs)) {
            $bloggerModel = new BloggerModel();

            foreach ($blogs as $blog) {
                // Check if blog with 'gbid' already exists
                $existingBlog = $bloggerModel->where('userid', $userid)
                    ->where('gbid', $blog['gbid'])
                    ->first();

                if ($existingBlog) {
                    // Blog exists, check for updates
                    if ($existingBlog['title'] != $blog['name'] || $existingBlog['url'] != $blog['url']) {
                        // Update the blog details
                        $bloggerModel->update($existingBlog['id'], [
                            'title' => $blog['name'],
                            'url' => $blog['url']
                        ]);
                    }
                } else {
                    // Blog does not exist, insert a new record
                    $bloggerModel->insert([
                        'userid' => $userid,
                        'gbid' => $blog['gbid'],
                        'title' => $blog['name'],
                        'url' => $blog['url'],
                    ]);
                }
            }
        }
    }
}
