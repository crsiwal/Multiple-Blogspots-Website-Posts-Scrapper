<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Post Scrapper</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url("vendor/bootstrap/css/bootstrap.min.css"); ?>">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/style.css"); ?>">
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<?= (is_login()) ? $this->include('partials/sidebar') : $this->include('partials/nosidebar'); ?>