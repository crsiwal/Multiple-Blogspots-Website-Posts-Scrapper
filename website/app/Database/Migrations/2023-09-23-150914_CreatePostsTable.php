<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostsTable extends Migration {
    public function up() {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'Unique id of post',
            ],
            'blogid' => [
                'type' => 'INT',
                'unsigned' => true,
                'comment' => 'Unique id of Blog ref blogs->id',
            ],
            'postgid' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'comment' => 'Unique blog post id generated by google blogger',
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 512,
                'default' => null,
                'comment' => 'Post title',
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 512,
                'default' => null,
                'comment' => 'Post unique slug in english for seo',
            ],
            'summery' => [
                'type' => 'VARCHAR',
                'constraint' => 512,
                'default' => null,
                'comment' => 'Post short summery for search for seo',
            ],
            'content' => [
                'type' => 'TEXT',
                'default' => null,
                'comment' => 'Post content with html supported',
            ],
            'tags' => [
                'type' => 'VARCHAR',
                'constraint' => 512,
                'default' => null,
                'comment' => 'Comma seperated tags for post to blogspot',
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 4,
                'default'    => 0,
                'comment' => 'Status of post 0:pending,1:Scraped,2:Draft,3:Skipped,4:Scheduled,5:Posted',
            ],
            'posttime' => [
                'type' => 'DATETIME',
                'default' => null,
                'comment' => 'Timestamp when post will be posted to blogspot',
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
        $this->forge->createTable('posts');
    }

    public function down() {
        $this->forge->dropTable('posts');
    }
}
