<script>
if (typeof Dropzone !== 'undefined') {
	Dropzone.autoDiscover=false;
}
</script>

<main itemscope itemtype="http://schema.org/[og.itemtype;noerr;magnet=#]">
	<div id="cpn-profile-canvas">


		<div id="cpn-profile-top" style="background-image:url([profile.cover;magnet=#])">
			<span id="cpn-cover-upload">
				[onshow;block=span;when [profile.edit]=1]
				Upload Cover Photo
				[onshow;svg=static/svg/upload.svg]
				<input id="cover-upload" type="file" name="file" accept="image/*"
					data-url="[afurl.base]/[profile.type]/set/cover?id=[profile.id]" />
			</span>

			<a href="[afurl.base]/[profile.url]" id="cpn-profile-icon">
				<span>
					[onshow;block=span;when [profile.edit]=1]
					Upload New Pic
					<input id="icon-upload" type="file" name="file" accept="image/*"
						data-url="[afurl.base]/[profile.type]/set/icon?id=[profile.id]" />
				</span>
				<img src="[profile.img]" alt="[profile.name]" class="cpn-profile-pic-[profile.id]" />
			</a>
			<div>
				<div class="cpn-profile-stats">
					<a href="[afurl.base]/[profile.url]/[actions.link;magnet=#]">
						<span>[actions.count]</span>
						[actions.$;block=a]
					</a>
				</div>
				<div class="cpn-propfile-bar">
					<a class="cpn-profile-name" href="[afurl.base]/[profile.url]">
						[profile.name]
					</a>

				</div>
			</div>
		</div>

		<div class="cpn-profile-social">
			<span>[profile.sub]</span>
			<div>
				<a itemprop="sameas" target="_blank" href="[social.social_url;block=a]">
					[onshow;svg=static/social2/[social.social_type;f=urlname].svg]
				</a>
				<a data-featherlight="[afurl.base]/[profile.type]/links?id=[profile.id]">
					[onshow;block=a;when [profile.id]=[user.user_id]]
					[onshow;block=a;when [profile.type]=profile]
					[onshow;svg=static/social2/edit.svg]
				</a>
			</div>
		</div>

		<div id="cpn-profile-body">
