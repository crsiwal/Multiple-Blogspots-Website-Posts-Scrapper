<div class="col-12 my-3">
	<div class="form-floating">
		<input type="text" id="posttitle" name="title" class="form-control" placeholder="Enter post title" value="<?= isset($post["title"]) ? $post["title"] : ""; ?>" />
		<label for="posttitle" class="form-label">Post title</label>
	</div>
</div>

<div class="col-12 mb-3">
	<div class="form-floating">
		<input type="text" id="postslug" name="slug" class="form-control" placeholder="Enter post slug" value="<?= isset($post["slug"]) ? $post["slug"] : ""; ?>" />
		<label for="posttitle" class="form-label">Post Slug</label>
	</div>
</div>

<div class="col-12 mb-3">
	<div class="form-floating">
		<textarea name="summary" class="form-control" id="postsummary" rows="5"><?= isset($post["summary"]) ? strip_tags($post["summary"], '<h1><p><img><div><ul><ol><li><table><th><tr><td>') : ""; ?></textarea>
		<label for="postsummary" class="form-label">Post Summary</label>
	</div>
</div>

<div class="col-12 mb-3">
	<div class="mb-2">Post to following blogs</div>
	<div class="row p-3">
		<?php
		foreach ($bloggers as $id => $title) {
		?>
			<div class="col-md-4 form-check py-2">
				<label class="form-check-label pointer" for="bloggers_<?= $id; ?>">
					<input name="blogger[]" class="form-check-input" type="checkbox" value="<?= $id; ?>" id="bloggers_<?= $id; ?>">
					<?= $title; ?>
				</label>
			</div>
		<?php
		}
		?>
	</div>
</div>

<div class="col-12 mb-3">
	<div class="form-floatings">
		<label for="posttags" class="form-label">Post Tags <small>(Comma seperated)</small></label>
		<div>
			<select id="posttags" name="tags[]" multiple="multiple">
				<?php
				foreach (explode(",", $post["tags"]) as $tag) {
				?>
					<option selected="selected" value="<?= $tag; ?>"><?= $tag; ?></option>
				<?php
				}
				?>
			</select>
		</div>
	</div>
</div>

<div class="col-12 mb-3 d-flex justify-content-center">
	<?= anchor("posts/reject/" . $post["id"], '<i class="fas fa-ban me-2"></i></i>Reject post', ["class" => "btn btn-lg btn-danger"]); ?>
	<button type="submit" name="act" value="draft" class="btn btn-lg btn-primary ms-3"><i class="far fa-save me-2"></i> Draft post</button>
	<button type="submit" name="act" value="schedule" class="btn btn-lg btn-success ms-3"><i class="fas fa-cloud-upload-alt me-2"></i> Schedule post</button>
</div>