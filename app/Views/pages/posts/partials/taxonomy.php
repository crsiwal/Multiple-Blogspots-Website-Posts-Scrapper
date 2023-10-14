<div class="col-12 my-3">
	<div class="form-floating">
		<input type="text" id="posttags" name="tags" class="form-control" placeholder="Enter post tags" value="<?= isset($post["tags"]) ? $post["tags"] : ""; ?>" />
		<label for="posttags" class="form-label">Post Tags <small>(Comma seperated)</small></label>
	</div>
</div>