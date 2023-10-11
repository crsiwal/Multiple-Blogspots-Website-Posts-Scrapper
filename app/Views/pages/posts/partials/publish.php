<div class="col-auto my-5 text-center">
	<?= anchor("posts/reject/" . $post["id"], '<i class="fas fa-ban me-2"></i></i>Reject post', ["class" => "btn btn-danger"]); ?>
	<button type="submit" name="act" value="draft" class="btn btn-primary ms-3"><i class="far fa-save me-2"></i> Draft post</button>
	<button type="submit" name="act" value="schedule" class="btn btn-success ms-3"><i class="fas fa-cloud-upload-alt me-2"></i> Schedule post</button>
</div>