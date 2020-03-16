<div id="gallery-image">
	<div id="gallery-image-container">
		<div id="gallery-image-right">&gt;</div>
		<div id="gallery-image-left">&lt;</div>
		<img id="gallery-item" src="" style="max-width:100%; max-height:100%" />
	</div>
</div>


<div id="gallery-side"><div id="gallery-side-container"></div></div>



<div id="gallery-thumb">
	<div class="scroll-target cpn-nav-bar">
		<div class="viewport">
			<div class="overview">
				<span class="gallery-thumb gallery-thumb-add">
					[onshow;block=span;when [gallery.user_id]=[user.user_id]]
					+
				</span><span class="gallery-thumb">
					<img src="[thumbs.url;block=span]" data-src="[thumbs.img]" />
				</span>
			</div>
		</div>
		<div class="scrollbar" style="top:-20px"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>

	</div>
</div>


<script>
[onshow;block=script;when [gallery.user_id]=[user.user_id]]
[onshow;block=script;when '[gallery.upload]'='1']
$(function(){
	popup('[afurl.base]/gallery/new?id=[gallery.id]&type=[gallery.type]', 'Upload Photos To Gallery');
});
</script>

<script>
[onshow;block=script;when [gallery.user_id]=[user.user_id]]
$(function(){
	$('.gallery-thumb-add').click(function(){
		popup('[afurl.base]/gallery/new?id=[gallery.id]&type=[gallery.type]', 'Upload Photos To Gallery');
	});
});
</script>


<script>
selectimage = function(item) {
	$('.gallery-selected').removeClass('gallery-selected');

	if ($(item).is('img')) item = $(item).parent();
	var img = $(item).find('img');

	$(item).addClass('gallery-selected');
	$('#gallery-item').attr('src', $(img).attr('data-src'));

	var hash = $(img).attr('data-src');
	if (typeof(hash) == 'undefined') return;

	var pos = hash.lastIndexOf('/');
	if (pos > 0) hash = hash.substr(pos+1);

	var param = '?gallery=[gallery.id]&type=[gallery.type]';
	$('#gallery-side-container').load( '[afurl.base]/gallery/sidebar/' + hash + '/' + param );

	var url	= History.getState().hash;
	var pos	= url.indexOf('?');
	if (pos > 0) url = url.substr(0, pos);
	History.replaceState({}, document.title, url+'?id='+hash);
};


$(function(){
	var id	= location.search.replace('?id=', '');
	var url	= History.getState().hash;
	var pos	= url.indexOf('?');
	if (pos > 0) url = url.substr(0, pos);
	//History.replaceState({}, document.title, url);


	History.Adapter.bind(window, 'statechange', function(){
		if (!history_block) return;
		var state = History.getState().cleanUrl.substr(10);
		var start = state.indexOf('/') + 1;
		var end   = state.indexOf('/', start);
		var part  = state.substr(start, end-start);
		if (part != 'gallery') gallery_close();
	});


	if (id.length > 4) {
		$('.gallery-thumb img').each(function(index, item){
			if ($(item).attr('data-src').indexOf(id) > 0) selectimage(item);
		});
	}

	if ($('.gallery-selected').length < 1) {
		selectimage( $('.gallery-thumb img').first() );
	}

	$('.gallery-thumb img').click(function(){selectimage(this);});


	$('#gallery-image-left').click(function(event){
		var item = $('.gallery-selected');
		if (!item.length) return;

		var prev = item.prev('.gallery-thumb');
		if (!prev.length) return;
		if (prev.hasClass('gallery-thumb-add')) return;

		selectimage(prev);
	});



	$('#gallery-image-right').click(function(event){
		var item = $('.gallery-selected');
		if (!item.length) return;

		var next = item.next('.gallery-thumb');
		if (!next.length) return;

		selectimage(next);
	});


	$('#gallery-thumb div').tinyscrollbar({axis:'x'});


	$(window).resize(function() {
		$('#gallery-thumb div').tinyscrollbar_update('relative');
	});

});
</script>

<style>
#gallery-image-left, #gallery-image-right {
	position:absolute;
	z-index:3;
	width:100px;
	height:100px;
	text-align:center;
	overflow:hidden;
	font-size:50px;
	padding-top:10px;
	background:#fff;
	color:#636466;
	opacity:0.1;
	cursor:pointer;
	display:none;
}

#gallery-image-left:hover, #gallery-image-right:hover { opacity:0.5; }
#gallery-image-left { left:0; }
#gallery-image-right { right:300px; }

#gallery-image-container:hover #gallery-image-left,
#gallery-image-container:hover #gallery-image-right {
	display:block;
}

#gallery-image {
	position:fixed;
	background:#636466;
	width:100%;
	height:100%;
	padding:0 300px 100px 0;
	top:0;
	left:0;
}

#gallery-image-container {
	width:100%;
	height:100%;
	overflow:hidden;
	text-align:center;

}

#gallery-side {
	position:fixed;
	top:0;
	right:0;
	width:300px;
	height:100%;
	padding:0 0 100px 0;
}

#gallery-side-container {
	position:relative;
	width:100%;
	height:100%;
	overflow-x:hidden;
	overflow-y:scroll;
	background:#fff;
}

.gallery-thumb {
	display:inline-block;
	margin:0;
	padding:0;
	border:0;
	width:100px;
	height:100px;
	opacity:0.75;
	cursor:pointer;
	vertical-align:top;
}

.gallery-thumb:hover {
	opacity:1.0;
}

.gallery-thumb img {
	width:100%;
	height:100%;
}

.gallery-thumb-add {
	font-size:50px;
	padding:10px 0;
	text-align:center;
	background:#888;
}

.gallery-selected {
	opacity:1.0;
}

#gallery-thumb {
	position:fixed;
	bottom:0;
	left:0;
	width:100%;
	height:100px;
	padding:0;
	white-space:nowrap;
}

#gallery-thumb .scroll-target {
	width:100%;
	height:100%;
	overflow:hidden;
	padding:0;
}


.scrollbar {opacity:0.5;}
.scrollbar:hover {opacity:1.0;}

.scroll-target .viewport { width: 100%; height: 100px; overflow: hidden; position: relative; }
.scroll-target .overview { list-style: none; position: absolute; left: 0; top: 0; }
.scroll-target .thumb .end,
.scroll-target .thumb { background-color: #003D5D; }
.scroll-target .scrollbar { position: relative; float: right; width: 15px; }
.scroll-target .track { background-color: #D8EEFD; height: 100%; width:13px; position: relative; padding: 0 1px; }
.scroll-target .thumb { height: 20px; width: 13px; cursor: pointer; overflow: hidden; position: absolute; top: 0; }
.scroll-target .thumb .end { overflow: hidden; height: 15px; width: 13px; }
.scroll-target .disable{ display: none; }
.noSelect { user-select: none; -o-user-select: none; -moz-user-select: none; -khtml-user-select: none; -webkit-user-select: none; }

body {overflow:hidden;}
</style>
