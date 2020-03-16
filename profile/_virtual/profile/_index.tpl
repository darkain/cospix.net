<section style="margin-left:-13px">

	<div style="float:left; width:530px">

		<div class="profile-box">
			[onshow;block=div;when [user.user_id]=[profile.id]]
			<h3 class="cpn-header">
				<span onclick="popup('[afurl.base]/profile/edit/youtube','Set YouTube Video')">Edit</span>
				[youtube.youtube_title;noerr;ifempty='YouTube Video']
			</h3>
			<iframe width="517" height="291" src="//www.youtube.com/embed/[youtube.youtube_id;magnet=iframe;noerr]?rel=0&amp;autoplay=0" style="border:0" allowfullscreen></iframe>
			<div class="profile-box-body" itemprop="description">
				[youtube.text;safe=no;noerr]
			</div>
		</div>

		<div class="profile-box" itemscope itemtype="http://schema.org/VideoObject">
			[onshow;block=div;when [user.user_id]!=[profile.id]]
			<h3 class="cpn-header">[youtube.youtube_title;noerr;ifempty='YouTube Video']</h3>
			<meta itemprop="duration" content="T[youtube.youtube_length;date=i;noerr]M[youtube.youtube_length;date=s;noerr]S" />
			<iframe width="517" height="291" src="//www.youtube.com/embed/[youtube.youtube_id;magnet=div;noerr]?rel=0&amp;autoplay=0" style="border:0" allowfullscreen></iframe>
			<div class="profile-box-body" itemprop="description">
				[youtube.text;safe=no;noerr]
			</div>
		</div>

		<div class="profile-box cpn-profile-recent">
			<h3 class="cpn-header">Recently Updated Costumes and Galleries</h3>
			<a href="[afurl.base]/[account.user_url]/[g.gallery_type]/[g.gallery_id]"><img src="[g.img]" alt="[g.gallery_name;block=a;bmagnet=div]" /><br/>[g.gallery_name;ifempty='Untitled']</a>
		</div>


		<div class="profile-box">
			<h3 class="cpn-header">Ask Me A Question</h3>
			[onshow;block=div;when [user.user_id]!=[profile.id]]
			[onshow;block=div;when [user.user_id]+-0]
			<div class="profile-box-body cpn-profile-ask">
				<textarea></textarea>
				<button class="cpn-btn-default" style="float:right;margin-top:5px">Ask</button>
				<div class="clear"></div>
			</div>
		</div>


		<div class="profile-box">
			<h3 class="cpn-header">Recent Questions</h3>
			<div class="profile-box-body">
				<ul class="cpn-map-list">
					<li><a href="[afurl.base]/ask/[ask.ask_id;block=li;bmagnet=((div))]" style="white-space:initial;line-height:1.2em">
						<img src="[ask.img;noerr;ifempty='[afurl.static]/thumb2/profile.svg']" alt="[ask.user_name]" />
						<span style="padding-top:0">[onshow;block=span;when '[ask.answer_time]'='0']unanswered</span>
						<strong>[ask.user_name] asked:</strong>
						[ask.question_text]
					</a></li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>


		<div class="profile-box">
			<h3 class="cpn-header">About Me</h3>
			<div class="profile-box-body cpn-profile-about" itemprop="description">
				<p>
					[onshow;block=p;when [profile.id]!=[user.user_id]]
					[account.bio;safe=no]
				</p>
				<p title="Click to edit" class="af-edit-field">
					[onshow;block=p;when [profile.id]=[user.user_id]]
					[account.bio;safe=no]
				</p>
				<textarea class="edit-field af-edit-field">[account.user_bio;safe=nobr][onshow;block=textarea;when [profile.id]=[user.user_id]]</textarea>
			</div>
		</div>
	</div>


	<div style="float:right; width:300px">

		<div class="profile-box cpn-badge-box">
			<h3 class="cpn-header">
				<span>[onshow;block=span;when [user.user_id]=[profile.id]]Add Badge</span>
				<span>[onshow;block=span;when [user.user_id]!=[profile.id]][onshow;block=span;when [user.permission.admin]=1]Add Badge</span>
				Badges
			</h3>
			<div class="profile-box-body" style="padding:3px">
				<a href="[afurl.base]/badge/[badge.badge_id;block=a]" class="cpn-badge">
					<img src="[afurl.static]/badge/[badge.badge_image]" alt="[badge.badge_name]" title="[badge.badge_name]"/>
				</a>
			</div>
		</div>

		<div class="profile-box cpn-type-box">
			<h3 class="cpn-header">
				<span>[onshow;block=span;when [user.user_id]=[profile.id]]Change</span>
				Things I Do
			</h3>
			<div class="profile-box-body large">
				<div><a href="[afurl.base]/profile/[types.key]">[types.val;block=div]</a></div>
			</div>
		</div>

		<div class="profile-box">
			<h3 class="cpn-header">Upcoming &amp; Recent Events</h3>
			<div class="profile-box-body" style="max-height:300px; overflow:auto">
				[onload;file=map/list.tpl]
			</div>
		</div>


		<div class="profile-box">
			<h3 class="cpn-header">Favorite Series</h3>
			<div class="profile-box-body cpn-home-popular large" style="max-height:400px; overflow:auto">
				<ul class="cpn-map-list">
					<li><a href="[afurl.base]/tag/series/[series.group_label;f=urlname;block=li;bmagnet=tr;noerr]">
						<img src="[series.thumb_hash;f=cdn;noerr;ifempty='[afurl.static]/thumb2/series.svg']" alt="[series.group_label]" />
						<strong>[series.group_label]</strong>
					</a></li>
				</ul>
			</div>
		</div>

	</div>

	<div class="clear"></div>

</section>


<script>
[onshow;block=script;when [user.user_id]=[profile.id]]
$(function(){
	$('.cpn-profile-about p').click(function() {
		$(this).hide();
		$('.cpn-profile-about textarea').show().focus();
	});

	$('.cpn-profile-about textarea').blur(function() {
		$.post(
			'[afurl.base]/profile/set/bio',
			{ id:[profile.id], value:$(this).val() },
			function(data) {
				$('.cpn-profile-about textarea').hide();
				$('.cpn-profile-about p').html(data).show();
			}
		);
	});

	$('.cpn-badge-box h3 span').click(function(){
		popup('[afurl.base]/badge/add', 'Add A Badge');
	});

	$('.cpn-type-box h3 span').click(function(){
		popup('[afurl.base]/profile/types', 'Change The Things I Do');
	});
});
</script>

<script>
[onshow;block=script;when [user.user_id]!=[profile.id]]
[onshow;block=script;when [user.permission.admin]=1]
$(function(){
	$('.cpn-badge-box h3 span').click(function(){
		popup('[afurl.base]/badge/add?id=[profile.id]', 'Add A Badge');
	});
});
</script>

<script>
[onshow;block=script;when [user.user_id]+-0]
$(function(){
	$('.cpn-profile-ask button').click(function(){
		var text = $('.cpn-profile-ask textarea').val().trim();
		if (text == '') return;
		$.post(
			'[afurl.base]/ask/ask?id=[profile.id]',
			{ text: text },
			function(data) { $('.cpn-profile-ask').html(data); }
		);
	});
});
</script>
