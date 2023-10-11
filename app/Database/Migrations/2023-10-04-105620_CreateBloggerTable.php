<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBloggerTable extends Migration {
    public function up() {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'Unique blogger id',
            ],
            'userid' => [
                'type' => 'INT',
                'unsigned' => true,
                'comment' => 'Unique user id of blogger ref. users->id',
            ],
            'gbid' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'comment' => 'Unique blogger id of blog',
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'Title of blog',
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'base url of blog eg. https://name.blogspot.com',
            ],
            'posted' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
                'comment' => 'How much posts posted to this blog from any resource',
            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'comment' => 'Is this blogger active to post',
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
        $this->forge->createTable('bloggers');
    }

    public function down() {
        $this->forge->dropTable('bloggers');
    }
}
