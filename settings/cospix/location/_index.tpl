<style>
.search-loading {
	background:none;
	background-image:url('[afurl.static]/img/loading.gif');
	background-size:100px 100px;
	background-repeat:no-repeat;
	background-position:center;
}

div.featherlight-content {
	max-width:98%;
}

#city-search-display {
	margin-top:10px;
	overflow:hidden;
	display:flex;
	flex-wrap:wrap;
}

#city-search-display>div {
	font-size:16px;
	float:left;
	width:375px;
	flex-grow:1;
	flex-shrink:1;
	padding:0.3em;
	margin:0 10px 10px 0;
	white-space:nowrap;
	overflow:hidden;
	text-overflow:ellipsis;
	background:#fff;
}

#city-search-display>div:hover {
	background:#00C8E6;
	color:#fff;
	cursor:pointer;
}

#city-search-display>div strong,
#city-search-display>div em {
	display:block;
	height:20px;
}

#city-seach-name {
	display:block;
	width:100%;
	font-size:1em;
	padding:0.5em;
}
</style>

<h3 style="padding-bottom:1em">Type in your city name to start searching<h3>

<input type="text" id="city-seach-name" />

<div id="city-search-display"></div>


<script>
$(function(){
	var search_text = '';
	var search_ajax = null;
	var search_time = null;

	var search_city = function() {
		var search = $(this).val();

		if (search_text === search) return;
		search_text = search;

		if (search_ajax) search_ajax.abort();
		if (search_time) clearTimeout(search_time);

		search_time = setTimeout(function(){
			search_ajax = $.get(
				[afurl.full;safe=json] + '/search',
				{jq:1, search:search},
				function(data) {
					$('#city-search-display')
						.removeClass('search-loading')
						.html(data);
				}
			);
		}, 200);
	}

	$('#city-seach-name')
		.change(search_city)
		.keydown(search_city)
		.keyup(search_city)
		.mousedown(search_city)
		.mouseup(search_city)
		.focus(search_city)
		.blur(search_city);
});
</script>
