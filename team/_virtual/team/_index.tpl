<section style="margin-left:-13px">

	<div style="float:left; width:530px">

		<div class="profile-box">
			[onshow;block=div;when [user.user_id]=[team.user_id]]
			<h3 class="cpn-header">
				[youtube.youtube_title;noerr;ifempty='YouTube Video']
				<span onclick="popup('[afurl.base]/profile/edit/youtube','Set YouTube Video')">Edit</span>
			</h3>
			<iframe width="517" height="291" src="//www.youtube.com/embed/[youtube.youtube_id;magnet=iframe;noerr]?rel=0&amp;autoplay=0" style="border:0" allowfullscreen></iframe>
			<div class="profile-box-body" itemprop="description">
				[youtube.text;safe=no;noerr]
			</div>
		</div>

		<div class="profile-box cpn-profile-recent">
			<h3 class="cpn-header">Recently Updated Costumes and Galleries</h3>
			<a href="[afurl.base]/[g.user_url;ifempty=[g.user_id]]/[g.gallery_type]/[g.gallery_id]"><img src="[g.img]" alt="[g.gallery_name;block=a;bmagnet=div]" /><br/>[g.gallery_name;ifempty='Untitled']</a>
		</div>


		<div class="profile-box">
			<h3 class="cpn-header">About Me</h3>
			<div class="profile-box-body cpn-profile-about" itemprop="description">
				<p>
					[onshow;block=p;when [user.user_id]!=[team.user_id]]
					[team.bio;safe=no]
				</p>
				<p title="Click to edit" class="af-edit-field">
					[onshow;block=p;when [user.user_id]=[team.user_id]]
					[team.bio;safe=no]
				</p>
				<textarea class="edit-field af-edit-field">[team.user_bio;safe=nobr][onshow;block=textarea;when [user.user_id]=[team.user_id]]</textarea>
			</div>
		</div>
	</div>


	<div style="float:right; width:300px">

		<div class="profile-box">
			<h3 class="cpn-header">Upcoming &amp; Recent Events</h3>
			<div class="profile-box-body" style="max-height:500px; overflow:auto">
				[onload;file=map/list.tpl]
			</div>
		</div>

	</div>

	<div class="clear"></div>

</section>


<script>
[onshow;block=script;when [user.user_id]=[team.user_id]]
$(function(){
	$('.cpn-profile-about p').click(function() {
		$(this).hide();
		$('.cpn-profile-about textarea').show().focus();
	});

	$('.cpn-profile-about textarea').blur(function() {
		$.post(
			'[afurl.base]/team/set/bio',
			{ id:[team.user_id], value:$(this).val() },
			function(data) {
				$('.cpn-profile-about textarea').hide();
				$('.cpn-profile-about p').html(data).show();
			}
		);
	});
});
</script>
