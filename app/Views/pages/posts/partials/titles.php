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
		<textarea name="summary" class="form-control editor" id="postsummary" rows="5"><?= isset($post["summary"]) ? strip_tags($post["summary"], '<h1><p><img><div><ul><ol><li><table><th><tr><td>') : ""; ?></textarea>
		<label for="postsummary" class="form-label">Post Summary</label>
	</div>
</div>