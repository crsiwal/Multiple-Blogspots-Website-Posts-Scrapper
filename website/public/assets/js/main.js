$(document).ready(function () {
	tinymce.init({
		selector: "#postbody",
		menubar: false,
		relative_urls: false,
		convert_urls: false,
		height: 580,
		skin: 'borderless',
		remove_script_host: false,
		highlight_on_focus: true,
		plugins: 'autolink link image media wordcount advcode table autosave fullscreen',
		toolbar: 'image media link underline checklist numlist bullist align outdent indent forecolor backcolor table fullscreen code blocks fontsize',
	});

	tinymce.init({
		selector: "#postsummery",
		menubar: false,
		relative_urls: false,
		convert_urls: false,
		height: 200,
		remove_script_host: false,
		highlight_on_focus: true,
		plugins: 'wordcount autosave',
		toolbar: 'fontsize',
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
});

