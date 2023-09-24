<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder {
    public function run() {
        $data = [
            [
                'name' => 'Rahul Siwal',
                'email' => 'crsiwal@gmail.com',
                'password' => password_hash('adminrandompass', PASSWORD_BCRYPT), // Hashed password
                'salt' => 'randompass',
                'status' => 1, // Active user
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null, // No updates yet
                'deleted_at' => null, // Not deleted
            ],
        ];

        // Insert the data into the 'users' table
        $this->db->table('users')->insertBatch($data);
    }
}
