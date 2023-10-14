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
					<th scope="col">Posted</th>
					<th scope="col">Status</th>
					<th scope="col">Last Updated</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if (isset($bloggers)) {
					foreach ($bloggers as $blog) {
				?>
						<tr>
							<th scope="row"><?= $blog["id"]; ?></th>
							<td>
								<div><?= anchor("posts/created/" . $blog["id"], $blog["title"]); ?></div>
								<small><?= $blog["url"]; ?></small>
							</td>
							<td><?= $blog["posted"]; ?></td>
							<td><?= $blog["active"] ? "Active" : "Paused" ?></td>
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