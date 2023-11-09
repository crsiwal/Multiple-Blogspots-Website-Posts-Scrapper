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
					<th scope="col">Posts</th>
					<th scope="col">Scraped</th>
					<th scope="col">Scheduled</th>
					<th scope="col">Posted</th>
					<th scope="col">Rejected</th>
					<th scope="col">Last Updated</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if (isset($blogs)) {
					foreach ($blogs as $blog) {
				?>
						<tr>
							<th scope="row"><?= $blog["id"]; ?></th>
							<td>
								<div><?= anchor("posts/blog/" . $blog["id"], $blog["title"]); ?></div>
								<small><?= $blog["url"]; ?></small>
							</td>
							<td><?= $blog["posts"]; ?></td>
							<td><?= $blog["scraped"]; ?></td>
							<td><?= ($blog["scheduled"] - $blog["posted"]); ?></td>
							<td><?= $blog["posted"]; ?></td>
							<td><?= $blog["rejected"]; ?></td>
							<td><?= (empty($blog["updated_at"])) ? "Never" : Time::parse($blog["updated_at"])->humanize(); ?></td>
						</tr>
				<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
</div>