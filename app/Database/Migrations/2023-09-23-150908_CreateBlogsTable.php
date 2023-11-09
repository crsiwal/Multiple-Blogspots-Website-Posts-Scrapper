<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlogsTable extends Migration {
    public function up() {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'Unique blog id',
            ],
            'userid' => [
                'type' => 'INT',
                'unsigned' => true,
                'comment' => 'Unique user id of user ref. users->id',
            ],
            'bloggerid' => [
                'type' => 'INT',
                'unsigned' => true,
                'comment' => 'Unique id of blogger to post data ref blogger->id',
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
            'gbid' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'comment' => 'Unique blogger id of blog',
            ],
            'posts' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
                'comment' => 'How much total posts in this blog resource',
            ],
            'scraped' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
                'comment' => 'How much posts are scraped and added to database',
            ],
            'scheduled' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
                'comment' => 'How much posts are scheduled. It will increase on schedule and decreased on actual post',
            ],
            'posted' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
                'comment' => 'How much posts posted to blogspot from this blog resource',
            ],
            'rejected' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
                'comment' => 'How much posts rejected from this blog resource',
            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'comment' => 'Is this blog active to get scrap',
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
        $this->forge->createTable('blogs');
    }

    public function down() {
        $this->forge->dropTable('blogs');
    }
}
