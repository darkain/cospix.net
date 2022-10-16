<main class="cpn-default cpn-discover">
	<h1 class="cpn-header cpn-discover-header">[af.title]</h1>
	[onload;file=[af.config.root]/discover.tpl]
</main>


<script>
var afScrollLoad	= false;
var afScrollPage	= parseInt('[page]');

var afScrollForever = function() {
	if (isNaN(afScrollPage)) return;

	var prometheus	= $('.prometheus-insert');
	var height		= prometheus.length ? 700 : 500;

	if (afScrollLoad) return;
	if ($(window).scrollTop() < $(document).height() - $(window).height() - height) return;
	afScrollLoad = true;

	if (prometheus.length) {
		$('<div class="cpn-loading" id="discover-loading"></div>')
			.insertBefore($('.prometheus-insert').first());
	} else {
		$('main.cpn-discover')
			.append('<div class="cpn-loading" id="discover-loading"></div>');
	}

	$.get(
		'[afurl.base]/discover',
		{ page: ++afScrollPage, jq:1 },
		function(data) {
			History.replaceState({}, document.title, '[router.parts.path]?page='+afScrollPage);
			if (prometheus.length) {
				var html = $(data);
				html.find('.prometheus-insert').remove();
				html = html.find('a').unwrap();
				html.insertBefore($('.prometheus-insert').first());
			} else {
				$('main.cpn-discover').append(data);
			}
			$('#discover-loading').remove();

			afScrollLoad = false;
		}
	).fail(function(){
		afScrollPage = NaN;
	});
}

$(window).scroll(afScrollForever);
$(window).resize(afScrollForever);
$(afScrollForever);
</script>
