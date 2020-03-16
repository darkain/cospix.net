<main class="cpn-default">
	<h1 class="cpn-header">[af.title]</h1>
	<div class="cpn-default larger justify">
		<p>
			You can submit photos for the Cospix.net Featured Photo of the Day, or
			vote on other people's photos. All features are based on user votes,
			so let the world know which images you love best! New Photo of the Day
			features will be presented each day at <b>Noon</b> <i>(Pacific Time)</i>.
		</p>
		<p>
			Each day's Photo of the Day winner will have their image featured on
			Cospix's various online accounts with links directly back to your
			Cospix.net profile! This is a great way to get your work shown off to
			our thousands of followers.
		</p>
		<p>
			Images more than a week old are automatically removed from the submission
			pool. You may replace your image at any time to reset this counter, or
			submit a new image after the week is up.
		</p>
	</div>



	<h1 class="cpn-header" style="margin-top:20px">
		<span id="votes-remain">
			[onload;block=span;when [user.user_id]+-0]
			[total;ope=sbx:3] Votes Remaining
		</span>
		Submissions
	</h1>
	<div class="cpn-default cpn-vote-list">
		<span>
			<a href="[afurl.base]/image/[g.hash]?gallery=[g.gallery_id]" class="cpn-thumb-link">
				<img src="[g.img;block=span]" alt="[g.user_name]" />
			</a>
			<b>[g.vote_total] Votes</b>
			<a href="[afurl.base]/featured/vote?id=[g.submission_id]" class="cpn-vote-link">
				[onload;block=a;when [user.user_id]+-0]
				[onshow;block=a;when '[g.vote_id]'='']
				+ Vote
			</a>
			<a href="[afurl.base]/featured/unvote?id=[g.submission_id]" class="cpn-vote-link">
				[onload;block=a;when [user.user_id]+-0]
				[onshow;block=a;when [g.vote_id]+-0]
				- Unvote
			</a>
			<a href="[afurl.base]/[g.user_url;ifempty=[g.user_id]]">[g.user_name]</a>
		</span>
		<div class="clear"></div>
	</div>



	<h1 class="cpn-header" style="margin-top:20px">
		<a href="[afurl.base]/featured/[onshow..now;date=Y-m]">
			Recently Featured
		</a>
	</h1>
	<div class="cpn-default cpn-vote-list larger">
		<span>
			<a href="[afurl.base]/image/[recent.hash]?gallery=[recent.gallery_id]" class="cpn-thumb-link">
				<img src="[recent.img;block=span]" alt="[recent.user_name]" />
			</a>
			<b>[recent.vote_total] Votes</b>
			<i class="cpn-vote-link">[recent.feature_timestamp;date='M jS']</i>
			<a href="[afurl.base]/[recent.user_url;ifempty=[recent.user_id]]">[recent.user_name]</a>
		</span>
		<div class="clear"></div>

		<div class="center">
			<a href="[afurl.base]/featured/[onshow..now;date=Y-m]" class="cpn-button larger" style="padding:5px 15px; margin:10px">View the full Featured Photo Calendar</a>
		</div>
	</div>



	<h1 class="cpn-header">
		[onload;block=h1;when [user.user_id]+-0]
		My Submission
	</h1>
	<div class="cpn-default">
		[onload;block=div;when [user.user_id]+-0]
		<div class="center">
			Note: Changing photos will result in all votes for your submission to be lost. You'll have ZERO!<br/>
			<button class="cpn-button" id="select-pix">
				Change Photo
			</button><br/>

			<a href="[afurl.base]/image/[image.hash;noerr;magnet=div]?gallery=[image.gallery_id;noerr]">
				<img src="[image.img;noerr]" />
			</a>
		</div>

		<div class="center">
			[onshow;block=div;when '[image.hash;noerr]'='']
			<button class="cpn-button" id="select-pix">
				Submit A Photo
			</button>
		</div>
	</div>
</main>


<div id="cpn-select-image-popup" title="Select an image" style="display:none"></div>


<script>
var total_votes = [total];

$('button#select-pix').click(function(){
	$('#cpn-select-image-popup').afpopup('[afurl.base]/image/select', {
		width:			$(window).width()	- 100,
		height:			$(window).height()	- 100,
		draggable:		false,
		dialogClass:	'af-no-title',
	});
});

$('.cpn-vote-link').click(function(e){
	e.preventDefault();

	var txt = $(this).text().trim().substr(0,1);
	var url = $(this).prop('href');

	if (txt == '+') {
		if (total_votes > 2) {
			$.afnotice('Votes are like wishes, you may only have three. Unless you\'re a Super Saiyan, then you can have over 9000!', 'Photo of the Day Voting');
			return;
		}
		$('#votes-remain').text((3 - ++total_votes) + ' Votes Remaining');
		$(this).text('- Unvote');
		$(this).closest('span').find('b').load(url+'&jq=1');
		$(this).prop('href', url.replace('/vote', '/unvote'));

	} else if (txt == '-') {
		$('#votes-remain').text((3 - --total_votes) + ' Votes Remaining');
		$(this).text('+ Vote');
		$(this).closest('span').find('b').load(url+'&jq=1');
		$(this).prop('href', url.replace('/unvote', '/vote'));
	}
});
</script>
