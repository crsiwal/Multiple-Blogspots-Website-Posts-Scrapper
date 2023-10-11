<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAccessTokenTable extends Migration {
    public function up() {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'Unique id',
            ],
            'userid' => [
                'type' => 'INT',
                'unsigned' => true,
                'comment' => 'Unique user id ref. users->id',
            ],
            'token' => [
                'type' => 'TEXT',
                'comment' => 'User Google access token in json format',
            ],
            'isvalid' => [
                'type' => 'TINYINT',
                'default'    => 1,
                'comment' => 'Is this token valid or not',
            ],
            'expired_at' => [
                'type' => 'DATETIME',
                'default' => null,
                'comment' => 'Timestamp when the token expired',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'comment' => 'Timestamp of when the blogger added',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'default' => null,
                'comment' => 'Timestamp of when the blogger was last updated',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'default' => null,
                'comment' => 'Timestamp of when the blogger was marked deleted',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('accesstoken');
    }

    public function down() {
        $this->forge->dropTable('accesstoken');
    }
}
