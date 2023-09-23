<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration {
    public function up() {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'User uniqe id',
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'comment' => 'User personal name',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'User email address',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'comment' => 'User unique encrypted password',
            ],
            'salt' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'comment' => 'Random salt for create encrypted password',
            ],
            'status' => [
                'type' => 'TINYINT',
                'default'    => 0,
                'comment' => 'Status of post 0:Inactive,1:Active',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'comment' => 'Timestamp of when the post was created',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'default' => null,
                'comment' => 'Timestamp of when the post was last updated',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'default' => null,
                'comment' => 'Timestamp of when the post was marked deleted',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down() {
        $this->forge->dropTable('users');
    }
}
