<div itemscope itemtype="http://schema.org/Photograph">

<div class="center" id="cospix-image-frame">
	<img src="[image.url]" itemprop="image" alt="[og.description]"
		id="cpn-big-image" style="max-width:100%" />
</div>

<script>
var big_image_resize = function() {
	$('#cpn-big-image').css('max-height', $(window).height()+'px').css('visibility', 'visible');
}

big_image_resize();
$(function(){big_image_resize();});
$(window).resize(big_image_resize);
$('#cpn-big-image').on('load',big_image_resize);
</script>


<main class="cpn-default" style="width:1000px" id="cospix-image-data">
	<h1 class="cpn-header" itemprop="name">[af.title]</h1>
	<div class="cpn-default center">

		<div style="margin:0 -10px 10px 0"><ul class="cpn-map-list cpn-share-list">
			<li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=[afurl.all;f=url]"><img src="[afurl.static]/social2/facebook.svg" alt="Share this cosplay photo on Facebook" /> Share this on Facebook</a></li>

			<li><a target="_blank" href="https://twitter.com/home?status=Check+out+this+image+on+@CospixNet+[afurl.all;f=url]"><img src="[afurl.static]/social2/twitter.svg" alt="Share this cosplay photo on Twitter" /> Tweet this on Twitter</a></li>

			<li><a target="_blank" href="https://plus.google.com/share?url=[afurl.all;f=url]"><img src="[afurl.static]/social2/googleplus.svg" alt="Share this cosplay photo on Google+" /> Share this on Google+</a></li>

			<li><a target="_blank" href="http://pinterest.com/pin/create/button?url=[afurl.all;f=url]&amp;media=[image.url;f=url]"><img src="[afurl.static]/social2/pintrest.svg" alt="Share this cosplay photo on Pinterest" /> Pin this on Pinterest</a></li>

			<li><a target="_blank" href="http://www.tumblr.com/share/photo?source=[image.url;f=url]&amp;click_thru=[afurl.all;f=url]"><img src="[afurl.static]/social2/tumblr.svg" alt="Share this cosplay photo on Tumblr" /> Share this on Tumblr</a></li>
		</ul><div class="clear"></div></div>

		<aside class="cpn-image-prev">
			<a href="[afurl.base]/image/[image.prev;noerr;magnet=a]?gallery=[image.gallery_id]"></a>
		</aside>

		<aside class="cpn-image-next">
			<a href="[afurl.base]/image/[image.next;noerr;magnet=a]?gallery=[image.gallery_id]"></a>
		</aside>


		<div class="largest" style="padding-bottom:10px">
			<a href="[afurl.base]/featured/[image.featured.feature_timestamp;date='Y-m';noerr]">
				[onshow;block=div; when [image.featured.feature_timestamp;noerr]+-0]
				Featured on: [image.featured.feature_timestamp;date='F jS';noerr]
			</a>
		</div>

		<button class="cpn-button larger cpn-favorite">
			[onshow;block=button;when '[image.favorite;noerr]'='0']
			Add to Favorites
			<span></span>
		</button>

		<button class="cpn-button larger cpn-favorite">
			[onshow;block=button;when '[image.favorite;noerr]'='1']
			Remove From Favorites
			<span></span>
		</button>

		<div class="larger">
			<a href="[afurl.base]/[owner.user_url;ifempty=[owner.user_id;noerr];noerr]/[owner.gallery_type;noerr]/[image.gallery_id]">[owner.gallery_name;noerr]</a>
			by
			<a href="[afurl.base]/[owner.user_url;ifempty=[owner.user_id;noerr];noerr]">[owner.user_name;noerr;magnet=div]</a>
		</div>
	</div>

	<div class="clear"></div>

	<div class="center">
		<a class="nodec" href="[afurl.base]/image/[thumbs.hash;block=a]?gallery=[thumbs.gallery_id]">
			<img src="[thumbs.img;ifempty='[afurl.static]/thumb2/image.svg']" alt="Thumb" style="width:100px;height:100px" />
		</a>
	</div>



	<div class="cpn-default cpn-image-details">
		<div style="width:350px;float:right">

			<div>
				<div id="cpn-image-download">

					<a id="cpn-image-credit"><figure>
						[onshow;block=a;when [image.owner]=1]
						<img src="[afurl.static]/thumb2/profile.svg" />
						<figcaption>Add credits to this image</figcaption>
					</figure></a>

					<a href="[image.cdn]" target="_blank"><figure>
						<img src="[afurl.static]/thumb2/download.svg" />
						<figcaption>View Original Image</figcaption>
					</figure></a>

					<a id="cpn-set-gallery-thumb"><figure>
						[onshow;block=a;when [image.owner]=1]
						<img src="[afurl.static]/thumb2/[owner.gallery_type;noerr].svg" />
						<figcaption>Set as [owner.gallery_type;ifempty=blank] thumbnail</figcaption>
					</figure></a>

					<a href="https://www.google.com/searchbyimage?image_url=[image.url;f=url]" target="_blank"><figure>
						<img src="[afurl.static]/thumb2/search.svg" />
						<figcaption>Google Reverse Image Search</figcaption>
					</figure></a>

					<a id="cpn-set-gallery-delete"><figure>
						[onshow;block=a;when [image.owner]=1]
						<img src="[afurl.static]/thumb2/remove.svg" />
						<figcaption>Remove photo from [owner.gallery_type;noerr]</figcaption>
					</figure></a>

				</div>

				<div class="clear"></div>

				<table class="cpn-exif">
					<tr><th>Copyright:</th><td>[exif.Copyright;magnet=tr;safe=no;noerr]</td></tr>
					<tr><th>Artist:</th><td>[exif.Artist;magnet=tr;safe=no;noerr]</td></tr>
					<tr><th>Make:</th><td>[exif.Make;magnet=tr;safe=no;noerr]</td></tr>
					<tr><th>Shutter:</th><td>[exif.ExposureTime;magnet=tr;safe=no;noerr] second</td></tr>
					<tr><th>Aperture:</th><td>[exif.COMPUTED.ApertureFNumber;magnet=tr;safe=no;noerr]</td></tr>
					<tr><th>Focal Length:</th><td>[exif.FocalLength;magnet=tr;safe=no;noerr]mm</td></tr>
					<tr><th>ISO Speed:</th><td>[exif.ISOSpeedRatings;magnet=tr;safe=no;noerr;first]</td></tr>
					<tr><th>Captured:</th><td>[exif.DateTimeOriginal;magnet=tr;safe=no;noerr]</td></tr>
				</table>
			</div>

			<div>
				<h3 class="cpn-header">Admin</h3>
				[onshow;block=div;when [user.user_id]=1]
				<a href="[afurl.base]/image/rebuild/[image.hash]" target="_blank">Rebuild</a> -
				<a href="[afurl.base]/image/replace/[image.hash]" target="_blank">Replace</a> -
				<a onclick="popup('[afurl.base]/image/nuke?hash=[image.hash]')">Nuke</a>
			</div>

		</div>

		<div style="width:600px;float:left">
			<h3 class="cpn-header">Description</h3>
			<div class="profile-box-body cpn-profile-about" itemprop="description">
				[onload;block=div;when [owner.user_id;noerr]!=[user.user_id]]
				<p>[image.text;safe=no;magnet=((div))]</p>
			</div>
			<div class="profile-box-body cpn-image-description cpn-profile-about" itemprop="description">
				[onload;block=div;when [owner.user_id;noerr]=[user.user_id]]
				<p title="Click to edit" class="af-edit-field">[image.text;safe=no]</p>
				<textarea class="edit-field af-edit-field">[image.file_text;safe=nobr]</textarea>
			</div>
		</div>

		<div style="width:600px;float:left">
			<h3 class="cpn-header">Comments</h3>
			[onload;file=comment/comment.tpl]
			[onload;file=comment/new.tpl]
		</div>

		<div class="clear"></div>
	</div>
</main>


<div class="cpn-default cpn-discover-parent" id="cospix-image-discover" style="margin:20px auto">
[onload;file=_cospix/discover.tpl]
</div>


<script>
$(function(){
	$(document).keyup(function(e){
		if (e.target.nodeName == 'INPUT') return;
		if (e.target.nodeName == 'SELECT') return;
		if (e.target.nodeName == 'TEXTAREA') return;

		if (e.keyCode == 37) {
			var hash = '[image.prev;noerr]';
			if (hash == '') return;
			redirect('[afurl.base]/image/'+hash+'?gallery=[image.gallery_id]');
		}

		if (e.keyCode == 39) {
			var hash = '[image.next;noerr]';
			if (hash == '') return;
			redirect('[afurl.base]/image/'+hash+'?gallery=[image.gallery_id]');
		}
	});

	$('.cpn-favorite').click(function(){
		var txt = $(this).text().trim().toLowerCase().split(' ');
		$.post('[afurl.base]/image/favorite/'+txt[0], {
			id:		[image.gallery_id],
			hash:	'[image.hash]',
		}, function(data){ $('.cpn-favorite').html(data) });
	});
});
</script>

<script>
[onshow;block=script;when [user.user_id]+-0]
[onshow;block=script;when [owner.user_id;noerr]=[user.user_id]]
$(function(){

	$('.cpn-tag-unlink').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		$.post('[afurl.base]/image/tag/delete', {
			id:		$(this).data('id'),
			hash:	'[image.hash]',
		}, refresh);
	});

	$('#cpn-set-gallery-thumb').click(function(){
		$.post(
			'[afurl.base]/gallery/set/thumb',
			'hash=[image.hash]&gallery=[owner.gallery_id;noerr]',
			refresh
		);
	});

	$('.cpn-image-description p').click(function() {
		$(this).hide();
		$('.cpn-image-description textarea').show().focus();
	});

	$('.cpn-image-description textarea').blur(function() {
		$.post(
			'[afurl.base]/image/set/description',
			{ hash:'[image.hash]', value:$(this).val() },
			function(data) {
				$('.cpn-image-description textarea').hide();
				$('.cpn-image-description p').html(data).show();
			}
		);
	});

	$('#cpn-set-gallery-delete').click(function(){
		if (!confirm('Are you SURE you want to remove this image from your [owner.gallery_type;noerr]?')) return;
		$.post(
			'[afurl.base]/gallery/delete/[owner.gallery_id;noerr]/[image.hash]',
			function(){
				redirect('[afurl.base]/[owner.user_url;noerr;ifempty='[owner.user_id;noerr]']/[owner.gallery_type;noerr]/[owner.gallery_id;noerr]')
			}
		);
	});

	$('#cpn-image-credit').click(function(){
		popup('[afurl.base]/image/credit?hash=[image.hash]','Add credits to this image');
	})

});
</script>




<script>
[onload;block=script;when 1=2]
/*
$('#cpn-gallery-image-text p').click(function() {
	$(this).hide();
	$('#cpn-gallery-image-text textarea').show().focus();
});

$('#cpn-gallery-image-text textarea').blur(function() {
	$.post(
		'[afurl.base]/gallery/set/text',
		{
			id:'[ image.gallery_id ]',
			hash:'[image.hash]',
			text:$(this).val()
		},
		function(data) {
			$('#cpn-gallery-image-text textarea').hide();
			$('#cpn-gallery-image-text p').html(data).show();
		}
	);
});
*/
</script>

</div>
