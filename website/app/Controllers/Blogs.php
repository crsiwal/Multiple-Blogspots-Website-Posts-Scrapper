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
                    $data["blog"] = $this->_blog_data($data["url"]);
                }
            } else {
                $data["error"] = $this->validator->getError('url');
            }
        }
        return view('header') . view('pages/blog/preview', $data) . view('footer');
    }

    private function _blog_data($blog_url, $resultCount = 25) {
        try {
            $client = \Config\Services::curlrequest([
                'baseURI' => $blog_url,
            ]);
            $response = $client->get("feeds/posts/default", [
                'timeout' => 30,
                'query' => [
                    'alt' => 'json',
                    'max-results' => $resultCount
                ]
            ]);
            if ($response->getStatusCode() == 200) {
                $blog = [];
                $data = json_decode($response->getBody());
                $t = '$t';
                $ost = 'openSearch$totalResults';
                $linklist = ["self", "alternate", "next"];
                if (isset($data->feed->title->$t)) {
                    $blog["title"] = $data->feed->title->$t;
                    $blog["subtitle"] = $data->feed->subtitle->$t;
                    $blog["category"] = array_column($data->feed->category, "term");
                    $blog["links"] = array_filter(
                        array_column($data->feed->link, "href", "rel"),
                        function ($key) use ($linklist) {
                            return in_array($key, $linklist);
                        },
                        ARRAY_FILTER_USE_KEY
                    );
                    $blog["total"] = $data->feed->$ost->$t;
                    $blog["posts"] = [];
                    if (isset($data->feed->entry) && count($data->feed->entry) > 0) {
                        foreach ($data->feed->entry as $post) {
                            $single = [
                                "id" => $post->id->$t,
                                "category" => array_column($post->category, "term"),
                                "title" => $post->title->$t,
                                "content" => isset($post->content->$t) ? $post->content->$t : (isset($post->summary->$t) ? $post->summary->$t : FALSE),
                                // "links" => array_column($post->link, "href", "rel"),
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
        } catch (\Throwable $th) {
            return FALSE;
        }
    }
}
