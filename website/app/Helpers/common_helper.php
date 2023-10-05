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
	$active = (trim($slug, "/") == $activePath);
?>
	<a href="<?= base_url($path); ?>" class="nav-link <?= $active ? "text-primary" : " link-dark"; ?>">
		<i class="<?= ($brand) ? "fab" : ($active ? "fas" : "far"); ?> <?= $icon; ?> me-2"></i>
		<?= $name; ?>
	</a>
<?php
}

function is_login() {
	return false;
}
