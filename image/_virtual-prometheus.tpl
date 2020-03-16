<div itemscope itemtype="http://schema.org/Photograph">

<div class="center" id="cospix-image-frame">
	<img src="[image.url]" itemprop="image" alt="[og.description]"
		id="cpn-big-image" style="max-width:100%" />
</div>


<main class="cpn-default" id="cospix-image-data">
	<h1 class="cpn-header" itemprop="name">[af.title]</h1>



	<div id="cospix-image-share" class="cpn-default">

		<a class="cpn-favorite">
			[onshow;block=a;when [image.favorite;noerr]!=1]
			[onshow;svg=static/svg/heart.svg]
			Add to Favs
		</a>

		<a class="cpn-favorite">
			[onshow;block=a;when [image.favorite;noerr]=1]
			[onshow;svg=static/svg/heart.svg]
			Remove from Favs
		</a>

		<a href="[afurl.base]/[owner.user_url;ifempty=[owner.user_id;magnet=a]]/gallery/[owner.gallery_id;noerro]">
			[onshow;svg=static/thumb2/gallery.svg]
			View Full Gallery
		</a>

		<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=[afurl.full;safe=url]">
			[onshow;svg=static/social2/facebook.svg]
			Share on Facebook
		</a>

		<a target="_blank" href="https://twitter.com/home?status=Check%20out%20this%20awesome%20%23cosplay%20photo%20on%20%40cospixnet%21%20[afurl.full;safe=url]">
			[onshow;svg=static/social2/twitter.svg]
			Share on Twitter
		</a>

		<a target="_blank" href="https://pinterest.com/pin/create/button/?url=[afurl.full;safe=url]&media=https:[image.url;f=url]&description=Check%20out%20this%20awesome%20cosplay%20photo%20on%20Cospix%21%20">
			[onshow;svg=static/social2/pinterest.svg]
			Share on Pinterest
		</a>

		<a target="_blank" href="https://plus.google.com/share?url=[afurl.full;safe=url]">
			[onshow;svg=static/social2/googleplus.svg]
			Share on Google+
		</a>

	</div>



	<div class="cpn-default center" style="margin-top:0.5em">
		<div class="largest" style="padding-bottom:10px">
			<a href="[afurl.base]/featured/[image.featured.feature_timestamp;date='Y-m';noerr]">
				[onshow;block=div; when [image.featured.feature_timestamp;noerr]+-0]
				Cospix Photo of the Day on [image.featured.feature_timestamp;date='F jS, Y';noerr]
			</a>
		</div>


		<div class="center">
			<a class="nodec" href="[afurl.base]/[thumbs.path]/gallery/[thumbs.gallery_id]/[thumbs.hash;block=a]">
				<img src="[thumbs.img;ifempty='[afurl.static]/thumb2/image.svg']" alt="Thumb" style="width:100px;height:100px" />
			</a>
		</div>


		<div class="cpn-exif">
			[onshow;svg=static/svg/camera.svg]
			<table>
				<tr>
					<th>Artist:</th>
					<td>[exif.Artist;magnet=tr;safe=no;noerr]</td>
				</tr>

				<tr>
					<th>Copyright:</th>
					<td>[exif.Copyright;magnet=tr;safe=no;noerr]</td>
				</tr>

				<tr>
					<th>Camera:</th>
					<td>[exif.Model;magnet=tr;safe=no;noerr]</td>
				</tr>

				<tr>
					<th>Settings:</th>
					<td>
						ISO [exif.ISOSpeedRatings;magnet=tr;safe=no;noerr;first],
						[exif.ExposureTime;magnet=tr;safe=no;noerr]s,
						[exif.COMPUTED.ApertureFNumber;magnet=tr;safe=no;noerr]
					</td>
				</tr>

				<tr>
					<th>Focal Length:</th>
					<td>[exif.FocalLength;magnet=tr;safe=no;noerr]mm</td>
				</tr>
			</table>
		</div>

	</div>


	<div class="clear"></div>


	<div class="cpn-default cpn-image-details">

		<div id="cpn-image-download">

			<a id="cpn-image-credit">
				[onshow;block=a;when [image.owner]=999]
				[onshow;svg=static/thumb2/profile.svg]
				Add credits to this image
			</a>

			<a href="[afurl.base]/image/download/[image.hash]" target="_blank">
				[onshow;svg=static/thumb2/download.svg]
				Download Original Image
			</a>

			<a id="cpn-set-gallery-thumb">
				[onshow;block=a;when [image.owner]=1]
				[onshow;svg=static/thumb2/[owner.gallery_type;ifempty=blank].svg]
				Set as [owner.gallery_type;noerr] thumbnail
			</a>

			<a href="https://www.google.com/searchbyimage?image_url=https:[image.url;f=url]" target="_blank">
				[onshow;svg=static/thumb2/search.svg]
				Google Reverse Image Search
			</a>

			<a id="cpn-set-gallery-delete">
				[onshow;block=a;when [image.owner]=1]
				[onshow;svg=static/thumb2/remove.svg]
				Remove photo from [owner.gallery_type;noerr]
			</a>

		</div>


		<div>
			<h3 class="cpn-header">Admin</h3>
			[onshow;block=div;when [user.user_id]=1]
			<a href="[afurl.base]/image/rebuild/[image.hash]" target="_blank">Rebuild</a> -
			<a href="[afurl.base]/image/replace/[image.hash]" target="_blank">Replace</a> -
			<a onclick="popup('[afurl.base]/image/nuke?hash=[image.hash]')">Nuke</a>
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
	$('#cospix-image-data h1').click(function(){
		$('html,body').animate({
			scrollTop: ($(window).scrollTop() < 20) ? ($(window).height()-40) : 0
		}, 500);
	});

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

</div>
