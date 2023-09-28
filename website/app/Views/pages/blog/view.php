<?php

use CodeIgniter\I18n\Time;
?>

<div class="table-responsive min-vh-100">
	<table class="table caption-top">
		<caption>List of blogs</caption>
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Title</th>
				<th scope="col">URL</th>
				<th scope="col">Posts</th>
				<th scope="col">Scraped</th>
				<th scope="col">Scheduled</th>
				<th scope="col">Posted</th>
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
						<td><?= $blog["title"]; ?></td>
						<td><?= $blog["url"]; ?></td>
						<td><?= $blog["posts"]; ?></td>
						<td><?= $blog["scraped"]; ?></td>
						<td><?= $blog["scheduled"]; ?></td>
						<td><?= $blog["posted"]; ?></td>
						<td><?= (empty($blog["updated_at"])) ? "Never" : Time::parse($blog["updated_at"])->humanize(); ?></td>
					</tr>
			<?php
				}
			}
			?>
		</tbody>
	</table>
</div>