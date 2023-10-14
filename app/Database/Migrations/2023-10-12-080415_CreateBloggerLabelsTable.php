<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBloggerLabelsTable extends Migration {
    public function up() {
        $this->forge->addField([
            'bloggerid' => [
                'type' => 'INT',
                'unsigned' => true,
                'comment' => 'Unique id of blog ref blogger->id',
            ],
            'label' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'comment' => 'Post label',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'comment' => 'Timestamp when the record was created',
            ],
        ]);
        $this->forge->addKey(["bloggerid", "label"], true);
        $this->forge->createTable('bloggerlabels');
    }

    public function down() {
        $this->forge->dropTable('bloggerlabels');
    }
}
