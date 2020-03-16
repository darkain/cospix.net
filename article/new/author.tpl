<article class="cpn-default">
	<div id="cpn-new-article">
		<input type="hidden" name="id" value="[article.article_id]" />
		<input type="hidden" name="type" value="[article.article_type]" />
		<input id="new-article-title"  class="cpn-header" name="title" type="text" value="[article.article_title;ifempty='Article Title']">
		<textarea id="new-article-text" name="text">[article.article_text]</textarea>
		<div class="cpn-new-article-footer">
			<span>
				[onshow;block=span;when [article.article_type]='conreport']
				Convention:
				<input type="text" name="convention" value="[article.event_name]" />
			</span>
		</div>
	</div>
</article>

<script>
$('#new-article-title').focus(function(){
	if ($(this).val().trim()=='Article Title') $(this).val('');
}).blur(function(){
	if ($(this).val().trim()=='') {
		$(this).val('Article Title');
	}
})


$('.cpn-new-article-footer input').autocomplete({
	position: { my:'right bottom', at:'right top' },
	source: '[afurl.base]/event/auto/attending',
	minLength: 1,
});



tinymce.init({
	plugins:'save image link emoticons fullscreen table',
	external_plugins:{
		'jbimages':'[afurl.static]/tinymce/plugins/jbimages/plugin.js?2',
	},

	selector:'textarea',
	height:500,
	convert_fonts_to_spans:true,
	relative_urls:false,
	convert_urls:false,
	remove_script_host:false,

	toolbar:'save | undo redo | fontselect | fontsizeselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | link jbimages | emoticons | fullscreen',

	menu:{
		edit	: {title : 'Edit'  , items : 'undo redo | cut copy paste pastetext | selectall'},
		insert	: {title : 'Insert', items : 'link media | template hr'},
		view	: {title : 'View'  , items : 'visualaid'},
		format	: {title : 'Format', items : 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
		table	: {title : 'Table' , items : 'inserttable tableprops deletetable | cell row column'},
	},

	font_formats:
		'Default=Trebuchet MS,Helvetica Neue,Helvetica,Arial,sans-serif;'+
		'Andale Mono=andale mono,times;'+
		'Arial=arial,helvetica,sans-serif;'+
		'Arial Black=arial black,avant garde;'+
		'Book Antiqua=book antiqua,palatino;'+
		'Comic Sans MS=comic sans ms,sans-serif;'+
		'Courier New=courier new,courier;'+
		'Georgia=georgia,palatino;'+
		'Helvetica=helvetica;'+
		'Impact=impact,chicago;'+
		'Symbol=symbol;'+
		'Tahoma=tahoma,arial,helvetica,sans-serif;'+
		'Terminal=terminal,monaco;'+
		'Times New Roman=times new roman,times;'+
		'Trebuchet MS=trebuchet ms,geneva;'+
		'Verdana=verdana,geneva;'+
		'Webdings=webdings;'+
		'Wingdings=wingdings,zapf dingbats',

	save_enablewhendirty:false,

	save_onsavecallback:function(){
		if ($('#new-article-title').val().trim() == 'Article Title') { alert('You cannot have an empty title'); return; }
		if ($('#new-article-title').val().trim() == '') { alert('You cannot have an empty title'); return; }
		if ($('#new-article-text').val().trim() == '') { alert('Your article is empty!'); return; }

		$.post(
			'[afurl.base]/article/post',
			$('#cpn-new-article').afSerialize(),
			function(data) { $('article').html(data); }
		);
	}
 });
</script>
