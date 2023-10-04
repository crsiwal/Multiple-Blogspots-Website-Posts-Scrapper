<?php
$slug = uri_string();
?>
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
			<div class="col-md-2 pe-0">
				<section class="sticky-top" style="top: 0px;">
					<div class="d-flex flex-column flex-shrink-0 py-3 ps-2 bg-light min-vh-100">
						<a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
							<i class="fas fa-home me-2"></i>
							<span class="fs-4">Post Scrapper</span>
						</a>
						<hr>
						<ul class="nav nav-pills flex-column mb-auto ">
							<li class="nav-item">
								<a href="<?= base_url(); ?>" class="nav-link <?= trim($slug, "/") == "" ? "text-primary" : " link-dark"; ?>" aria-current="page">
									<i class="fas fa-home me-2"></i>
									Home
								</a>
							</li>
							<li>
								<a href="<?= base_url("blogs/new"); ?>" class="nav-link <?= trim($slug, "/") == "blogs/new" ? "text-primary" : " link-dark"; ?>">
									<i class="fas fa-home me-2"></i>
									New Blog
								</a>
							</li>
							<li>
								<a href="<?= base_url("posts/draft"); ?>" class="nav-link <?= trim($slug, "/") == "posts/draft" ? "text-primary" : " link-dark"; ?>">
									<i class="fas fa-list-ol me-2"></i>
									Draft
								</a>
							</li>
							<li>
								<a href="<?= base_url("posts/scheduled"); ?>" class="nav-link <?= trim($slug, "/") == "posts/scheduled" ? "text-primary" : " link-dark"; ?>">
									<i class="fas fa-home me-2"></i>
									Scheduled
								</a>
							</li>

							<li>
								<a href="<?= base_url("posts/created"); ?>" class="nav-link <?= trim($slug, "/") == "posts/created" ? "text-primary" : " link-dark"; ?>">
									<i class="fas fa-home me-2"></i>
									Posted
								</a>
							</li>

							<li>
								<a href="<?= base_url("posts/rejected"); ?>" class="nav-link <?= trim($slug, "/") == "posts/rejected" ? "text-primary" : " link-dark"; ?>">
									<i class="fas fa-home me-2"></i>
									Rejected
								</a>
							</li>

							<li class="dropdown">
								<a href="#" class="nav-link link-dark dropdown-toggle" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="fas fa-home me-2"></i>
									Bootstrap
								</a>
								<ul class="dropdown-menu text-small shadow" aria-labelledby="dropdown">
									<li><a class="dropdown-item" href="#">New project...</a></li>
									<li><a class="dropdown-item" href="#">Settings</a></li>
									<li><a class="dropdown-item" href="#">Profile</a></li>
								</ul>
							</li>
						</ul>
						<hr>
						<div class="dropdown">
							<a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
								<img src="https://www.rsiwal.com/static/media/personal.7779684e.jpg" alt="" width="32" height="32" class="rounded-circle me-2">
								<strong>Rahul Siwal</strong>
							</a>
							<ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
								<li><a class="dropdown-item" href="#">New project...</a></li>
								<li><a class="dropdown-item" href="#">Settings</a></li>
								<li><a class="dropdown-item" href="#">Profile</a></li>
								<li>
									<hr class="dropdown-divider">
								</li>
								<li><a class="dropdown-item" href="#">Sign out</a></li>
							</ul>
						</div>
					</div>
				</section>
			</div>