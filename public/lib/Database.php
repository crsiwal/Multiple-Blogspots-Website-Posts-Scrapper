<?php

class DataBase {

	public $db;

	private $server = "localhost";
	private $username = "root";
	private $password = "";
	private $database = "blogs";

	function __construct() {
		$this->db = new mysqli($this->server, $this->username, $this->password, $this->database);
		if ($this->db->connect_error) {
			die("Connection failed: " . $this->db->connect_error);
		}
	}

	function __destruct() {
		$this->db->close();
	}
}
