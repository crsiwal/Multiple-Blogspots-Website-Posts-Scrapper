<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Post Scrapper</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url("vendor/bootstrap/css/bootstrap.min.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/style.css"); ?>">
	<script src="https://cdn.tiny.cloud/1/h82tc4fozcxv5d1vmhi466melatmoa5791jkee9jzup7nijy/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<?= (is_login()) ? $this->include('partials/sidebar') : $this->include('partials/nosidebar'); ?>