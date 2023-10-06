<?php

namespace App\Controllers;

use App\Models\BloggerModel;

class Blogspot extends BaseController {

    public function index(): string {
        $bloggerModel = new BloggerModel();
        $data['bloggers'] = $bloggerModel->where("userid", login_user_id())->find();
        return view('header') . view('pages/blogger/view', $data) . view('footer');
    }
}
