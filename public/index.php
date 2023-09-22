<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

// Set the Path of the root directory
define('PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

$request = isset($_SERVER['REDIRECT_URL']) ? trim($_SERVER['REDIRECT_URL'], "/") : trim($_SERVER['REQUEST_URI'], "/");

$routes = [
	"" => ["path" => "home", "private" => true],
	"login" => ["path" => "login", "private" => false],
	"post/login" => ["path" => "RequestLogin", "private" => false],
];

if (isset($routes[$request])) {
	if ($routes[$request]["private"] === true) {
		if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
			load($routes[$request]["path"], "views");
		} else {
			header("Location: /login");
		}
	} else {
		load($routes[$request]["path"], "views");
	}
} else {
	load("index", "redirect");
}

function base_url($path = "") {
	return sprintf(
		"%s://%s%s",
		isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
		$_SERVER['SERVER_NAME'],
		"/" . $path
	);
}


function session($key, $clear = true) {
	if (isset($_SESSION[$key])) {
		$error = $_SESSION[$key];
		if ($clear) {
			unset($_SESSION[$key]);
		}
		return $error;
	}
	return null;
}

function load($filePath, $directory = "lib") {
	require PATH . "/" . $directory . "/" . $filePath . ".php";
}
