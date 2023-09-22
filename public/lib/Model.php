<?php
include "Database.php";
class DbModel extends DataBase {
	protected $table;
	public function __construct($tableName) {
		parent::__construct();
		$this->table = $tableName;
	}

	public function get() {
	}
}
