<div class="row">
	<textarea name="body" class="form-control editor" id="postbody" rows="10"><?= isset($post["content"]) ? strip_tags($post["content"], '<h1><br><p><img><div><ul><ol><li><table><th><tr><td>') : ""; ?></textarea>
</div>