<div itemscope itemtype="http://schema.org/ImageGallery">
	[onload;file=gallery/header.tpl]


	<section class="profile-box">
		[onload;block=section;when [user.user_id]!=[gallery.user_id]]
		<h3 class="cpn-header">Description</h3>
		<div style="padding:2px 2px 12px 2px">
			<div class="cpn-gallery-notes">
				<p>[gallery.text;safe=no;magnet=section]</p>
			</div>
		</div>
	</section>


	<section class="profile-box">
		[onload;block=section;when [user.user_id]=[gallery.user_id]]
		<h3 class="cpn-header">Description</h3>
		<div style="padding:2px 2px 12px 2px">
			[onload;file=costume/details.tpl]
		</div>
	</section>



	<section class="profile-box">
		<h3 class="cpn-header">Tutorials</h3>
		<div style="padding:2px">
			[onload;file=costume/tutorials.tpl]
		</div>
	</section>



	<section class="profile-box">
		<h3 class="cpn-header">Credits</h3>
		<div style="padding:2px">
			<ul class="cpn-account-list" style="margin:2px 9px">
				<li><a class="cpn-account-name" href="[afurl.base]/[credits.user_url;ifempty='[credits.user_id]';block=li;bmagnet=section]/[credits.gallery_type]/[credits.gallery_id]" data-id="[credits.user_id]">
					<img src="[credits.img;ifempty='[afurl.static]/thumb2/profile.svg']" alt="[credits.user_name]" />
					[credits.user_name]
					<span class="cpn-account-subtext">[credits.gallery_name;magnet=span]</span>
					<span class="cpn-account-subtext">[credits.role;magnet=span]</span>
				</a></li>
			</ul>
			<div class="clear"></div>
		</div>
	</section>



	<section class="profile-box">
		<h3 class="cpn-header"><span>Last Updated: [gallery.gallery_updated]</span> Photos</h3>
		<div style="padding:2px">
			[onload;file=gallery/thumbs.tpl]
			<div class="clear"></div>
		</div>
	</section>


	<section class="profile-box cpn-comments">
		<h3 class="cpn-header">Comments</h3>
		[onload;file=comment/comment.tpl]
		[onload;file=comment/new.tpl]
	</section>
</div>

[onload;file=gallery/scripts.tpl]
