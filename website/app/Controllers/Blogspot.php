<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Blogspot extends BaseController {

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    public function index(): string {
        return "Hello";
    }
}
