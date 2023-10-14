<?php

function vd() {
	echo "<pre>";
	$args = func_get_args(); // Get all passed arguments
	foreach ($args as $arg) {
		var_dump($arg); // Use var_dump to display the variable content
	}
	echo "</pre>";
	die();
}

function menulink($name, $icon, $path = "", $activePath = "", $brand = false) {
	$slug = uri_string();
	$active =  empty($activePath) ? false : (strpos($slug, $activePath) !== false ? true : false);
?>
	<a href="<?= base_url($path); ?>" class="nav-link <?= $active ? "text-primary" : " link-dark"; ?>">
		<i class="<?= ($brand) ? "fab" : ($active ? "fas" : "far"); ?> <?= $icon; ?> me-2"></i>
		<?= $name; ?>
	</a>
<?php
}

function is_login() {
	return (login_user_id()) ? TRUE : FALSE;
}

function login_user_id() {
	if (session()->has("user_loggedin")) {
		return (session("user_loggedin")) ? session("login_user_id") : FALSE;
	}
	return FALSE;
}

function get_login_user($field = NULL) {
	if (is_login()) {
		$user = session("loggedin_user_data");
		if (empty($field)) {
			return $user;
		} else {
			return isset($user[$field]) ? $user[$field] : FALSE;
		}
	}
	return FALSE;
}


function login_user($userid, $user) {
	if (session()->has("user_loggedin") && session("user_loggedin")) {
		return FALSE;
	} else {
		session()->set([
			"login_user_id" => $userid,
			"user_loggedin" => TRUE,
			"loggedin_user_data" => $user,
		]);
		return TRUE;
	}
	return FALSE;
}

function logout() {
	session()->destroy();
}
