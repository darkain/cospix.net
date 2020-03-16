<div class="cpn-header" id="gallery-sidebar-header">
	<img id="cpn-gallery-close" class="pointer" src="[afurl.static]/glyph-white/close.png" style="margin-left:10px;float:right" />

	<div class="cpn-more">
		<div class="cpn-more-content">
			<a target="_blank" href="[afurl.base]/gallery/download/[image.hash]">Download</a>
			<div id="cpn-set-gallery-thumb">
				[onshow;block=div;when [image.user_id]=[user.user_id]]
				Set As Thumb
			</div>
			<div id="cpn-set-gallery-delete">
				[onshow;block=div;when [image.user_id]=[user.user_id]]
				Delete
			</div>
		</div>
	</div>

	<span class="sidebar-btn sidebar-btn-details">Details</span>
	<span class="sidebar-btn sidebar-btn-exif">Exif</span>
	<div class="clear"></div>
</div>

<div id="cpn-gallery-details">
	<div style="margin-top:1em">
		<h4 class="b" style="color:#00C8E6;font-size:1.5em">Description</h4>
		<div id="cpn-gallery-image-text">
			<p class="edit-field">[image.file_text]</p>
			<textarea class="edit-field">[image.file_text;safe=nobr]</textarea>
		</div>
	</div>

	<div class="cpn-comments">
		<h4 class="b" style="color:#00C8E6;font-size:1.5em">Comments</h4>
		[onload;file=comment/comment.tpl]
		[onload;file=comment/new.tpl]
	</div>
</div>

<div id="cpn-gallery-exif">
	<h3>Camera EXIF Data</h3>
	<div>
		<div>Copyright:<br /><b>[tabs.exif.Copyright;magnet=div;noerr]</b></div>
		<table class="cpn-exif">
			<tr><th>Artist:</th><td>[tabs.exif.Artist;magnet=tr;noerr]</td></tr>
			<tr><th>Make:</th><td>[tabs.exif.Make;magnet=tr;noerr]</td></tr>
			<tr><th>Camera:</th><td>[tabs.exif.Model;magnet=tr;noerr]</td></tr>
			<tr><th>Lens:</th><td>[tabs.exif.LensModel;magnet=tr;noerr]</td></tr>
			<tr><th>Shutter:</th><td>[tabs.exif.ExposureTime;magnet=tr;noerr] second</td></tr>
			<tr><th>Aperture:</th><td>[tabs.exif.COMPUTED.ApertureFNumber;magnet=tr;noerr]</td></tr>
			<tr><th>Focal Length:</th><td>[tabs.exif.FocalLength;magnet=tr;noerr]mm</td></tr>
			<tr><th>ISO Speed:</th><td>[tabs.exif.ISOSpeedRatings;magnet=tr;noerr]</td></tr>
			<tr><th>Captured:</th><td>[tabs.exif.DateTimeOriginal;magnet=tr;noerr]</td></tr>
			<tr><th>Software:</th><td>[tabs.exif.Software;magnet=tr;noerr]</td></tr>
		</table>
	</div>
</div>


<style>
#cpn-gallery-image-text p {
	padding:0;
	margin:0;
	cursor:text;
	min-height:1em;
}

#cpn-gallery-image-text textarea {
	width:100%;
	height:300px;
	display:none;
}

.edit-field:hover {
	background-color:#FFFFD3;
}

#gallery-side-container {
	padding:5px;
}

#gallery-sidebar-header {
	overflow:visible;
}

#gallery-sidebar-header .sidebar-btn {
	display:inline-block;
	font-size:20px;
	padding:1px 10px;
	cursor:pointer;
}

#gallery-sidebar-header .sidebar-btn:hover {
	background:#fff;
	color:#00C8E6;
}

a.cpn-gallery-back {
	display:inline-block;
	vertical-align:top;
	text-decoration:none;
	color:#00C8E6;
	background:#fff url('[afurl.static]/glyph-cyan/back.png') no-repeat left top;
	padding:6px 5px 0 35px;
	height:32px;
	font-size:14px;
	max-width:230px;
	overflow:hidden;
	white-space:nowrap;
}

a.cpn-gallery-back:hover {
	color:#fff;
	background:#00C8E6 url('[afurl.static]/glyph-white/back.png') no-repeat left top;
}



/* EXIF DATA */
#cpn-gallery-exif {
	margin-top:10px;
	display:none;
}

#cpn-gallery-exif h3 {
	color:#00C8E6;
	margin-bottom:5px;
}

#cpn-gallery-exif .ui-widget-content {
	background:#eee;
}


#cpn-gallery-exif .ui-corner-top, #cpn-gallery-exif .ui-corner-bottom {
	border-radius:0;
}


#cpn-gallery-exif td, #gallery-tab-3 th {
	padding:3px;
	vertical-align:top;
}

#cpn-gallery-exif th {
	font-weight:normal;
	text-align:right;
	white-space:nowrap;
}

#cpn-gallery-exif td {
	font-weight:bold;
	overflow:hidden;
}
</style>

<script>
$('#cpn-gallery-close').click(function(){gallery_close(1)});

$('.sidebar-btn-details').click(function(){
	$('#cpn-gallery-exif').hide();
	$('#cpn-gallery-details').show();
});

$('.sidebar-btn-exif').click(function(){
	$('#cpn-gallery-details').hide();
	$('#cpn-gallery-exif').show();
});

$('#cpn-set-gallery-thumb').click(function(){
	var img  = $('.gallery-selected img');
	if (!img.length) return;

	var hash = $(img).attr('data-src');
	if (typeof(hash) == 'undefined') return;

	var pos = hash.lastIndexOf('/');
	if (pos > 0) hash = hash.substr(pos+1);

	$.post(
		'[afurl.base]/gallery/set/thumb',
		'hash=' + hash + '&gallery=[image.gallery_id]',
		function() {alert('Gallery Thumb Updated!')}
	);
});

$('#cpn-set-gallery-delete').click(function(){
	var img  = $('.gallery-selected img');
	if (!img.length) return;

	var hash = $(img).attr('data-src');
	if (typeof(hash) == 'undefined') return;

	var pos = hash.lastIndexOf('/');
	if (pos > 0) hash = hash.substr(pos+1);

	$.post(
		'[afurl.base]/gallery/delete/[image.gallery_id]/' + hash,
		refresh
	);
});
</script>

<script>
[onshow;block=script;when [image.user_id]=[user.user_id]]
$('#cpn-gallery-image-text p').click(function() {
	$(this).hide();
	$('#cpn-gallery-image-text textarea').show().focus();
});

$('#cpn-gallery-image-text textarea').blur(function() {
	$.post(
		'[afurl.base]/gallery/set/text',
		{
			id:'[image.gallery_id]',
			hash:'[image.hash]',
			text:$(this).val()
		},
		function(data) {
			$('#cpn-gallery-image-text textarea').hide();
			$('#cpn-gallery-image-text p').html(data).show();
		}
	);
});
</script>
