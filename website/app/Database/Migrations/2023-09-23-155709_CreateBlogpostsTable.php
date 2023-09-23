<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlogpostsTable extends Migration {
    public function up() {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'User uniqe id',
            ],
            'blogid' => [
                'type' => 'INT',
                'unsigned' => true,
                'comment' => 'Unique id of Blog ref blogs->id',
            ],
            'postid' => [
                'type' => 'INT',
                'unsigned' => true,
                'comment' => 'Unique id of Blog ref posts->id',
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 512,
                'comment' => 'Post title',
            ],
            'postgbid' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'comment' => 'Post blogger unique id',
            ],
            'posturl' => [
                'type' => 'VARCHAR',
                'constraint' => 512,
                'comment' => 'Post unique url',
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
        $this->forge->createTable('blogposts');
    }

    public function down() {
        $this->forge->dropTable('blogposts');
    }
}
