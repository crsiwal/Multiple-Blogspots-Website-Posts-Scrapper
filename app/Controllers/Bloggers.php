<?php

namespace App\Controllers;

use App\Models\BloggerLabelsModel;
use App\Models\BloggerModel;
use CodeIgniter\API\ResponseTrait;

class Bloggers extends BaseController {

    public function index(): string {
        $bloggerModel = new BloggerModel();
        $data['bloggers'] = $bloggerModel->where("userid", login_user_id())->find();
        return view('header') . view('pages/blogger/view', $data) . view('footer');
    }

    public function labels() {
        $term = $this->request->getGet('term');
        $blogers = $this->request->getGet('blogger');
        // Load the model
        $bloggerLabelsModel = new BloggerLabelsModel();

        // Perform database query based on the search term and bloggerid(s)
        if (!empty($term)) {
            $bloggerLabelsModel->like('label', $term);
        }

        if (!empty($blogers)) {
            $bloggerLabelsModel->whereIn('bloggerid', explode(",", "$blogers"));
        }

        $labels = $bloggerLabelsModel->groupBy("label")->limit(50)->find();

        // Prepare data for Select2 format
        $data = ["results" => []];
        foreach ($labels as $label) {
            $data["results"][] = [
                'id' => $label['label'],
                'text' => $label['label']
            ];
        }

        // Return data as JSON
        return $this->response->setJSON($data);
    }
}
