<div class="col-12 my-3">
	<label for="posttags" class="form-label">Post Tags <small>(Comma seperated)</small></label>
	<input type="text" id="posttags" name="tags" class="form-control" placeholder="Enter post tags" value="<?= isset($post["tags"]) ? $post["tags"] : ""; ?>" />
</div>