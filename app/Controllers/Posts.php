<?php

namespace App\Controllers;

use KubAT\PhpSimple\HtmlDomParser;
use App\Models\PostsModel;
use CodeIgniter\HTTP\RedirectResponse;

class Posts extends BaseController {

    public function __construct() {
        $this->postModel = new PostsModel();
        $this->db = \Config\Database::connect();
    }

    public function blogPost($blog_id): string {
        $data['posts'] = $this->postModel->where([
            "userid" => login_user_id(),
            "blogid" => $blog_id,
            "status" => 1, // Scraped
        ])->findAll(10);
        return view('header') . view('pages/posts/view', $data) . view('footer');
    }

    public function statusPosts($status): string {
        $data['posts'] = $this->postModel->where([
            "userid" => login_user_id(),
            "status" => $status,
        ])->findAll(50);
        return view('header') . view('pages/posts/view', $data) . view('footer');
    }

    public function singlePost($post_id): string {
        $data['post'] = $this->postModel->where([
            "userid" => login_user_id(),
            "id" => $post_id,
        ])->first();

        if (isset($data['post']["id"])) {
            $data['next'] = $this->postModel->where([
                "blogid" => $data["post"]["blogid"],
                "id >" => $data['post']["id"],
                "status" => 1, // Scraped
            ])->limit(1)->first();
            $data['post']["images"] = [];
            $dom = HtmlDomParser::str_get_html($data['post']["content"]);
            foreach ($dom->find('img') as $image) {
                if ($image->width > 250) {
                    $imageUrl = $image->src;
                    array_push($data['post']["images"], $imageUrl);
                }
            }
            $dom->clear();
            return view('header') . view('pages/posts/single', $data) . view('footer');
        }
    }

    public function rejectPost($post_id): RedirectResponse {
        $post = $this->postModel->select(["id", "blogid"])->where([
            "userid" => login_user_id(),
            "id" => $post_id,
            "status" => 1 // Scraped
        ])->first();
        if (isset($post["id"])) {
            $request = $this->postModel->update($post["id"], [
                "userid" => login_user_id(),
                "status" => 3 // Skipped
            ]);
            if ($request) {
                $this->db->table('blogs')
                    ->set("rejected", "rejected + 1", false)
                    ->set("updated_at", date('Y-m-d H:i:s'))
                    ->where("id", $post["blogid"])
                    ->update();
                $next = $this->postModel->select("id")->where([
                    "blogid" => $post["blogid"],
                    "id >" => $post["id"],
                    "status" => 1,
                ])->limit(1)->first();
                if (isset($next["id"])) {
                    sleep(1);
                    return redirect()->to('posts/single/' . $next["id"]);
                }
            }
        }
        return redirect()->to("");
    }

    public function editPost($post_id) {
        $data['post'] = $this->postModel->where([
            "id" => $post_id,
            "status" => 1, // Scraped
        ])->first();

        if (isset($data['post']["id"])) {
            helper('form');
            return view('header') . view('pages/posts/edit', $data) . view('footer');
        } else {
            return redirect()->to('posts/single/' . $post_id);
        }
    }

    public function schedulePost() {
        if ($this->request->is('post')) {
            $rules = [
                'psid' => 'required',
                'psgid' => 'required',
                'title' => 'required|max_length[512]',
                'slug' => 'required|max_length[512]',
                'summary' => 'required|max_length[160]',
                'tags' => 'required|max_length[512]',
                'body' => 'required',
            ];
            if ($this->validate($rules)) {
                $data = $this->validator->getValidated();
                $post = $this->postModel->where([
                    "userid" => login_user_id(),
                    "id" => $data["psid"],
                    "postgid" => $data["psgid"],
                    "status" => 1,
                ])->first();
                if (isset($post["id"])) {
                    $status = $this->postModel->update($post["id"], [
                        "title" => $data["title"],
                        "slug" => $data["slug"],
                        "summary" => $data["summary"],
                        "content" => $data["body"],
                        "tags" => $data["tags"],
                        "status" => 4, // Scheduled
                        "post_at" => date('Y-m-d H:i:s')
                    ]);
                    if ($status) {
                        $this->db->table('blogs')
                            ->set("scheduled", "scheduled + 1", false)
                            ->set("updated_at", date('Y-m-d H:i:s'))
                            ->where("id", $post["blogid"])->update();
                        $next = $this->postModel->select("id")->where([
                            "blogid" => $post["blogid"],
                            "id >" => $post["id"],
                            "status" => 1,
                        ])->first();
                        if (isset($next["id"])) {
                            sleep(1);
                            return redirect()->to('posts/edit/' . $next["id"]);
                        }
                    }
                }
            } else {
                $errors = $this->validator->getErrors();
                $error = reset($errors);
                \Config\Services::session()->setFlashdata('error', $error);
            }
        } else {
            \Config\Services::session()->setFlashdata('error', 'Unable to handle your request.');
        }
        return redirect()->back();
    }
}