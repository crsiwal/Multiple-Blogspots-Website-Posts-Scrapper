$(document).ready(function () {
	tinymce.init({
		selector: "#postbody",
		menubar: false,
		relative_urls: false,
		convert_urls: false,
		height: 580,
		skin: 'borderless',
		remove_script_host: false,
		highlight_on_focus: false,
		plugins: 'code autolink link image media wordcount table autosave fullscreen',
		toolbar: 'image media link underline checklist numlist bullist align outdent indent forecolor backcolor table fullscreen code blocks fontsize',
	});

	tinymce.init({
		selector: "#postsummary",
		menubar: false,
		relative_urls: false,
		convert_urls: false,
		height: 200,
		remove_script_host: false,
		highlight_on_focus: false,
		plugins: 'wordcount autosave',
		toolbar: false,
	});

	tinymce.init({
		selector: ".editor",
		menubar: false,
		relative_urls: false,
		convert_urls: false,
		remove_script_host: false,
		highlight_on_focus: true,
		plugins: 'autolink link image media wordcount advcode table autosave fullscreen',
		toolbar: 'image media link underline checklist numlist bullist align outdent indent forecolor backcolor table fullscreen code blocks fontsize',
	});


	$("#posttags").select2({
		theme: "bootstrap-5",
		closeOnSelect: false,
		tags: [],
		ajax: {
			url: "/bloggers/labels/json",
			dataType: 'json',
			type: "GET",
			quietMillis: 1000,
			data: function (params) {
				return {
					term: params.term,
					blogger: function () {
						return $("input[name='blogger[]']:checked").map(function () {
							return $(this).val();
						}).get();
					}
				};
			}
		}
	});

});

