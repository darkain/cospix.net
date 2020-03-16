<style>
.cpn-lfs {
	padding:5px;
	border-top:3px solid #eee;
}

.cpn-lfs-new {
	width:100%;
}

.cpn-lfs-new th, .cpn-lfs-new td {
	font-size:32px;
	vertical-align:top;
}

table.cpn-lfs-new td {
	font-size:32px;
}

.cpn-lfs-new th {
	width:220px;
	padding-right:10px;
}

.cpn-lfs-new textarea {
	width:100%;
}

.cpn-lfs-new button {
	width:100%;
	font-size:32px;
	height:80px;
	margin:6px 0;
}

#create-lfs {
	margin:1em auto;
	width:900px;
	padding:15px;
	display:block;
	font-size:32px;
	min-height:70px;
}

#new-lfs {
	display:none;
	margin:20px auto;
}

table.cpn-folder td {font-size:32px;}

.lfs-username {
	font-size:32px;
	line-height:1em;
	color:#aaa;
}

.lfs-username span { font-size:24px; font-style: italic; }

.lfs-username a { text-decoration:none; }

.lfs-username button {
	float:right;
	font-size:24px;
	padding:15px 20px;
}

.lfs-lookingfor {
	font-size:24px;
	line-height:1em;
	padding-bottom:10px;
	color:#aaa;
}
</style>

<button id="create-lfs" class="cpn-button">
	[onshow;block=button;when [user.user_id]+-0]
	Create New #LFS
</button>

<a id="create-lfs" class="cpn-button" href="[afurl.base]/login">
	Login to create new #LFS
	[onshow;block=a;when [user.user_id]=0]
</a>

<main class="cpn-default" id="new-lfs">
	[onshow;block=main;when [user.user_id]+-0]
	<h1 class="cpn-header">Create New #LFS</h1>
	<div class="cpn-default">
		<table class="cpn-lfs-new">
			<tr><th class="right">I am a</th><td>
				<table class="cpn-folder" id="cpn-lfs-iam"><tbody><tr>
					<td class="cpn-folder-selected">Cosplayer</td>
					<td>Photographer</td>
					<td>Videographer</td>
				</tr></tbody></table>
			</td></tr>

			<tr><th class="right">Looking for a</th><td>
				<table class="cpn-folder" id="cpn-lfs-looking"><tbody><tr>
					<td>Cosplayer</td>
					<td class="cpn-folder-selected">Photographer</td>
					<td>Videographer</td>
				</tr></tbody></table>
			</td></tr>

			<tr><th class="right">Location</th><td>
				<table class="cpn-folder" id="cpn-lfs-location"><tbody><tr>
					<td class="cpn-folder-selected">In Message</td>
					<td>Gazebo</td>
					<td>Fountains</td>
					<td>Grass Hill</td>
				</tr><tr>
					<td>Front Desk</td>
					<td>Sand Giant</td>
					<td>Wavy Wall</td>
					<td>Pool</td>
				</tr></tbody></table>
			</td></tr>

			<tr><th class="right">Message</th><td>
				<textarea></textarea>
			</td></tr>

			<tr><th></th><td>
				<button class="cpn-button">Publish</button>
			</td></tr>
		</table>
		<div style="font-size:18px; line-height:1em;">
			<em>NOTE: This will override any existing postings you already have on this page, because, well, you can't be at two places at once looking for shoots, now can you?</em> ★~(◠△◕✿)
		</div>
	</div>
</main>

<main class="cpn-default" style="margin-top:10px">
	<h1 class="cpn-header">Looking For Shoots</h1>

	<div style="font-size:18px;line-height:1em" class="center i">NOTE: This is an experimental feature for usage during Katsucon ONLY. This list will be cleared after this weekend.</div>

	<div style="margin:15px 0">
		<table class="cpn-folder" id="cpn-lfs-type"><tbody><tr>
			<td class="cpn-folder-selected">All</td>
			<td>Cosplayers</td>
			<td>Photographers</td>
			<td>Videographers</td>
		</tr></tbody></table>
	</div>

	<div id="lfs-body" class="cpn-default">
		[onload;file=lfs.tpl]
	</div>
</main>

<script>
$(function(){
	$('#cpn-lfs-type td').click(function(){
		var page = $(this).first('.cpn-folder-selected').text();
		$('#lfs-body').load('[afurl.base]/tools/lfs/lfs?page='+page);
	});

	$('button#create-lfs').click(function(){
		$(this).hide();
		$('#new-lfs').show();
	});

	$('.cpn-folder td').click(function(){
		$(this).closest('table').find('.cpn-folder-selected').removeClass('cpn-folder-selected');
		$(this).addClass('cpn-folder-selected');
	});

	$('.cpn-lfs-new button').click(function(){
		$('#new-lfs').css('opacity', '0.5');
		$.post(
			'[afurl.base]/tools/lfs/publish', {
				iam: $('#cpn-lfs-iam .cpn-folder-selected').text(),
				looking: $('#cpn-lfs-looking .cpn-folder-selected').text(),
				location: $('#cpn-lfs-location .cpn-folder-selected').text(),
				text: $('.cpn-lfs-new textarea').val(),
			}, refresh
		);
	});

	var sortlfs = function(){
		var focused = $(':focus');
		var group = $('.wrapper');
		group.find('.cpn-lfs').sort(function (a, b) {
			return $(b).data('sort') - $(a).data('sort');
		}).appendTo(group);
		focused.focus();
	};

	setTimeout(sortlfs, 1000);

	$('.lfs-republish').click(function(){
		var that = this;
		$.post(
			'[afurl.base]/tools/lfs/republish',
			{ id: $(this).closest('.cpn-lfs').data('id') },
			function(data) {
				var date = new Date();  //TODO: MAKE CONVENTION TIMEZONE DYNAMIC HERE!!
				date.setTime((parseInt(data) - 18000 + (date.getTimezoneOffset()*60))*1000)
				$(that).closest('.cpn-lfs').data('sort', data);
				$(that).closest('.cpn-lfs').find('.lfs-timestamp').html(
					'posted ' + afWeek(date) + ' at ' + afAmpm(date)
				);
				sortlfs();
			}
		);
	});
});
</script>
