<div class="col-md-2 pe-0">
	<section class="sticky-top" style="top: 0px;">
		<div class="d-flex flex-column flex-shrink-0 py-3 ps-2 bg-light min-vh-100">
			<a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none text-primary">
				<i class="fas fa-yin-yang fs-2 me-2"></i>
				<span class="fs-3">Scrapper</span>
			</a>
			<hr>
			<ul class="nav nav-pills flex-column mb-auto ">
				<li><?= menulink("Home", "fa-home", "/", "/"); ?></li>
				<li><?= menulink("Draft", "fa-stream", "posts/draft", "posts/draft"); ?></li>
				<li><?= menulink("Scheduled", "fa-clock", "posts/scheduled", "posts/scheduled"); ?></li>
				<li><?= menulink("Posted", "fa-check-double", "posts/created", "posts/created"); ?></li>
				<li><?= menulink("Rejected", "fa-trash", "posts/rejected", "posts/rejected"); ?></li>
				<li><?= menulink("Bloggers", "fa-blogger-b", "bloggers", "bloggers", true); ?></li>
			</ul>
			<hr>
			<div class="dropdown">
				<a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
					<img src="<?= get_login_user("picture"); ?>" alt="" width="32" height="32" class="rounded-circle me-2">
					<strong><?= get_login_user("name"); ?></strong>
				</a>
				<ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
					<li><?= menulink("New Blog", "fa-plus", "blogs/new", "blogs/new"); ?></li>
					<li><?= menulink("Profile", "fa-user", "profile", "profile"); ?></li>
					<hr class="dropdown-divider">
					<li><?= menulink("Sign out", "fa-sign-out-alt", "logout"); ?></li>
				</ul>
			</div>
		</div>
	</section>
</div>