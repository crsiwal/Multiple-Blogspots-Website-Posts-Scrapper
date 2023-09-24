<div class="min-vh-100">
	<div class="row">
		<div class="col-12 col-md-6">
			<?= form_open('blogs/new', ['class' => 'd-flex', 'id' => 'htmlform']) ?>
			<input type="text" id="blogurl" name="url" class="form-control" placeholder="Blogger base URL" value="<?= isset($url) ? $url : ""; ?>" />
			<button type="submit" class="btn btn-primary ms-3">Preview</button>
			<?= form_close(); ?>
		</div>
	</div>
	<?php
	if (isset($blog) && is_array($blog)) {
	?>
		<div class="row mt-5">
			<div class="col-12">
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