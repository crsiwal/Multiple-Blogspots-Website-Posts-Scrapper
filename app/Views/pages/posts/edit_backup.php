<div class="col-md-10 mb-4">
	<?php if (session()->has('error')) : ?>
		<div class="row">
			<div class="col-12">
				<div class="alert alert-danger">
					<?= session('error') ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?= form_open('posts/schedule', ['class' => '', 'id' => 'htmlform'], ["psid" => $post["id"], "psgid" => $post["postgid"]]) ?>
	<div class="row">
		<ul class="nav nav-tabs" id="myTab">
			<li class="nav-item col-md-2">
				<a href="#titles" class="nav-link active" data-bs-toggle="tab">Titles</a>
			</li>
			<li class="nav-item col-md-2">
				<a href="#taxonomy" class="nav-link" data-bs-toggle="tab">Taxonomy</a>
			</li>
			<li class="nav-item col-md-2">
				<a href="#content" class="nav-link" data-bs-toggle="tab">Content</a>
			</li>
			<li class="nav-item col-md-2">
				<a href="#publish" class="nav-link" data-bs-toggle="tab">Publish</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade show active" id="titles">
				<?= $this->include('pages/posts/partials/titles'); ?>
			</div>
			<div class="tab-pane fade" id="taxonomy">
				<?= $this->include('pages/posts/partials/taxonomy'); ?>
			</div>
			<div class="tab-pane fade" id="content">
				<?= $this->include('pages/posts/partials/content'); ?>
			</div>
			<div class="tab-pane fade" id="publish">
				<?= $this->include('pages/posts/partials/publish'); ?>
			</div>
		</div>
	</div>
	<?= form_close(); ?>
</div>