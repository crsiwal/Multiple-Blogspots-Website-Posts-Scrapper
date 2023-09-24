<?php

function vd(...$vars) {
	echo "<pre>";
	var_dump($vars);
	echo "</pre>";
	die();
}
