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
                'comment' => 'Post uniqe id',
            ],
            'postid' => [
                'type' => 'INT',
                'unsigned' => true,
                'comment' => 'Unique id of Blog ref posts->id',
            ],
            'bloggerid' => [
                'type' => 'INT',
                'unsigned' => true,
                'comment' => 'Unique id of blog ref blogger->id',
            ],
            'postgbid' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'default' => null,
                'comment' => 'Post blogger unique id',
            ],
            'posturl' => [
                'type' => 'VARCHAR',
                'constraint' => 1024,
                'default' => null,
                'comment' => 'Post blogspot unique url',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'comment' => 'Timestamp when the record was created',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'default' => null,
                'comment' => 'Timestamp of when the record was last updated',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('bloggerposts');
    }

    public function down() {
        $this->forge->dropTable('bloggerposts');
    }
}
