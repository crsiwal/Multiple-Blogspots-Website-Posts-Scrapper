<?php

use CodeIgniter\I18n\Time;
?>
<div class="col-md-8 mb-4">
	<!--Section: Post data-mdb-->
	<section class="border-bottom mb-4 text-center">
		<?php
		if (isset($post["images"]) && count($post["images"]) > 0) {
			$image_url = array_shift($post["images"]);
		?>
			<img src="<?= $image_url; ?>" class="single-post-img" alt="<?= $post["title"]; ?>" />
		<?php
		}
		?>
		<h1 class="h3 mt-4"><?= $post["title"]; ?></h1>
	</section>

	<section class="border-bottom mb-4">
		<div><?= $post["content"]; ?></div>
	</section>
</div>
<div class="col-md-2 mb-4 bg-light">
	<section class="sticky-top" style="top: 8px;">
		<section class="pb-4 mb-4">
			<div class="d-flex flex-column text-center p-4">
				<?php
				if (isset($next["id"])) {
					echo anchor("posts/single/" . $next["id"], '<i class="fas fa-step-forward me-2"></i>Go to next', ["class" => "btn btn-primary my-4"]);
				}
				?>
				<?= anchor("posts/edit/" . $post["id"], '<i class="far fa-edit me-2"></i>Edit post', ["class" => "btn btn-success my-4"]); ?>
				<?= anchor("posts/reject/" . $post["id"], '<i class="fas fa-ban me-2"></i></i>Reject post', ["class" => "btn btn-danger my-4"]); ?>
			</div>
		</section>
	</section>
</div>