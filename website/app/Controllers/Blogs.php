<?php

namespace App\Controllers;

use App\Models\BlogsModel;

class Blogs extends BaseController {
    public function index(): string {
        $blogsModel = new BlogsModel();
        $data['blogs'] = $blogsModel->findAll();
        return view('header') . view('pages/blog/view', $data) . view('footer');
    }

    public function preview(): string {
        helper('form');
        $data = [];
        if ($this->request->is('post')) {
            $rules = [
                'url' => 'required|max_length[120]|valid_url_strict',
            ];
            if ($this->validate($rules)) {
                $data = $this->validator->getValidated();
                if (isset($data["url"])) {
                    $data["blog"] = $this->_blog_data($data["url"], 4);
                }
            } else {
                $data["error"] = $this->validator->getError('url');
            }
        }
        return view('header') . view('pages/blog/preview', $data) . view('footer');
    }

    public function addBlog() {
        if ($this->request->is('post')) {
            $rules = [
                'url' => 'required|max_length[120]|valid_url_strict',
            ];
            if ($this->validate($rules)) {
                $data = $this->validator->getValidated();
                $blog = $this->_blog_data($data["url"], 1);
                if (isset($blog["gbid"]) && !empty($blog["gbid"])) {
                    $blogsModel = new BlogsModel();
                    $query = $blogsModel->select('id')->where('gbid', $blog["gbid"])->get();
                    if ($query->getNumRows() == 0) {
                        $insert = $blogsModel->insert([
                            "userid" => 1,
                            "gbid" => $blog["gbid"],
                            "title" => $blog["title"],
                            "url" => isset($blog["links"]["alternate"]) ? $blog["links"]["alternate"] : $data["url"],
                            "posts" => $blog["total"],
                            "scheduled" => 0,
                            "posted" => 0,
                        ]);
                        if ($insert) {
                            return redirect()->to("/");
                        } else {
                            \Config\Services::session()->setFlashdata('error', 'Unable to add blog.');
                        }
                    } else {
                        \Config\Services::session()->setFlashdata('error', 'This blog is already exist.');
                    }
                } else {
                    \Config\Services::session()->setFlashdata('error', 'Unable to find this blog.');
                }
            } else {
                \Config\Services::session()->setFlashdata('error', 'Provide a valid url.');
            }
        } else {
            \Config\Services::session()->setFlashdata('error', 'This blog is already exist.');
        }
        return redirect()->to('/blogs/new');
    }

    private function _blog_data($blog_url, $max = 25, $offset = 1) {
        try {
            $client = \Config\Services::curlrequest([
                'baseURI' => $blog_url,
            ]);
            $response = $client->get("feeds/posts/default", [
                'timeout' => 30,
                'query' => [
                    'alt' => 'json',
                    'max-results' => $max,
                    'start-index' => ($offset < 1) ? 1 : $offset,
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
            echo 'Message: ' . $e->getMessage();
            return FALSE;
        }
    }
}
