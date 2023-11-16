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
		plugins: 'emoticons searchreplace preview code visualblocks lists autolink link image media wordcount table autosave fullscreen',
		toolbar: 'emoticons image media link code underline checklist numlist bullist align outdent indent forecolor backcolor table fontsize blocks searchreplace visualblocks preview fullscreen',
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
		plugins: 'emoticons searchreplace preview code visualblocks lists autolink link image media wordcount table autosave fullscreen',
		toolbar: 'emoticons image media link code underline checklist numlist bullist align outdent indent forecolor backcolor table fontsize visualblocks searchreplace visualblocks preview fullscreen',
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

