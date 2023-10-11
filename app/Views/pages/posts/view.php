<?php

use CodeIgniter\I18n\Time;
?>
<div class="col-md-10 mb-4">
	<div class="table-responsive min-vh-100">
		<table class="table caption-top">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Title</th>
					<th scope="col">Last Updated</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if (isset($posts)) {
					foreach ($posts as $post) {
				?>
						<tr>
							<th scope="row"><?= $post["id"]; ?></th>
							<td>
								<div><?= anchor("posts/single/" . $post["id"], $post["title"], ["class" => "link-dark text-decoration-none"]); ?></div>
								<small><b>Tags:</b> <?= $post["tags"]; ?></small>
								<small>, <b>Slug:</b> <?= $post["slug"]; ?></small>
							</td>
							<td><?= (empty($post["updated_at"])) ? "Never" : Time::parse($post["updated_at"])->humanize(); ?></td>
						</tr>
				<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
</div>