<div class="col-md-10 mb-4">
	<div class="min-vh-100 pt-3">
		<?php if (session()->has('error')) : ?>
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="alert alert-danger">
						<?= session('error') ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="row">
			<div class="col-12 col-md-6">
				<?= form_open('blogs/new', ['class' => 'd-flex', 'id' => 'htmlform']) ?>
				<input type="text" id="blogurl" name="url" class="form-control" placeholder="Blogger base URL" value="<?= isset($url) ? $url : ""; ?>" />
				<button type="submit" class="btn btn-primary ms-3">Preview</button>
				<?= form_close(); ?>
			</div>
			<?php
			if (isset($blog["contentallowed"])) {
				if ($blog["contentallowed"] == true) {
			?>
					<div class="col-12 col-md-6">
						<?= form_open('blogs/add', ['class' => 'd-flex', 'id' => 'htmlform'], ["url" => $url]) ?>
						<button type="submit" class="btn btn-primary ms-1 px-5">Add Blog</button>
						<?= form_close(); ?>
					</div>
				<?php
				} else {
				?>
					<div class="col-12 col-md-6">
						<button type="submit" class="btn btn-danger ms-1 px-5">Only summary available</button>
					</div>
			<?php
				}
			}
			?>
		</div>

		<?php
		if (isset($blog) && is_array($blog)) {
		?>
			<div class="row mt-4">
				<div class="col-12 d-flex">
					<p><b>Total Posts:</b> <?= $blog["total"]; ?></p>
					<p class="ps-3"><b>Category:</b> <?= count($blog["category"]); ?></p>
				</div>
				<div class="col-12 mt-1">
					<div class="list-group">
						<?php
						if (isset($blog["posts"]) && count($blog["posts"]) > 0) {
							foreach ($blog["posts"] as $i => $post) {
						?>
								<a href="#" class="list-group-item list-group-item-action flex-column border-0 border-bottom align-items-start">
									<h6 class="mb-1"><b>Title:</b> <?= $post["title"]; ?></h6>
									<p class="mb-1"><b>Tags:</b> <?= implode(",", $post["category"]); ?></p>
									<small><b>Content:</b> <?= $post["content"]; ?></small>
								</a>
						<?php
							}
						}
						?>
					</div>
				</div>
			</div>
		<?php
		}
		?>
	</div>
</div>