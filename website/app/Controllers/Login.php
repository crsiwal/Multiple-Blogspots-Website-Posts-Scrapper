<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;


class Login extends BaseController {

    public function __construct() {
        // $this->db = \Config\Database::connect();
    }

    public function index(): RedirectResponse {
        return redirect()->to("redirect/google");
    }
}
