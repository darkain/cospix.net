<style>
div.profile-flex {
	display:flex;
	flex-wrap:wrap;
	max-width:1800px;
	margin:auto;
	color:#fff;
}

div.profile-flex>div {
	flex-grow:1;
	flex-shrink:1;
	width:300px;
	margin:1em;
}



div.profile-things {
	background:#fff;
	border-radius:10px;
	padding:1em;
	box-shadow:inset 0 0 5px #000;
	color:#456;
}

div.profile-things>div {
	display:flex;
	flex-wrap:wrap;
}

div.profile-things>div>div {
	flex-grow:1;
	flex-shrink:1;
	width:120px;
}

div.profile-things h3 {
	color:#456;
	border-bottom:4px solid #456;
	padding-bottom:0.2em;
}

div.profile-things h3 span {
	float:right;
	font-size:0.75em;
	cursor:pointer;
}

div.profile-things h4 {
	font-size:1em;
	padding-top:1em;
	color:#00C8E6;
	font-weight:bold;
}

div.profile-things ul,
div.profile-things li {
	list-style:none;
	padding:0;
	margin:0;
}



div.cpn-profile-about h3 {
	border-bottom:4px solid #00C8E6;
	padding-bottom:0.2em;
	margin-bottom:1em;
}

div.cpn-profile-about p {
	text-align:left;
}

div.cpn-profile-about textarea {
	min-width:100%;
	max-width:100%;
}


div.profile-badges {
	margin-top:2em;
}

div.profile-badges>div {
	display:flex;
	flex-wrap:wrap;
}

div.profile-badges a {
	padding:0;
	margin:1em 1em 0 0;
	border-radius:9999px;
	width:60px;
	flex-grow:1;
	flex-shrink:1;
}

div.profile-badges svg {
	width:100%;
	height:100%;
}
</style>



<div class="profile-flex">
	<div class="cpn-profile-about">
		[onload;file=profile/about.tpl]
	</div>

	<div>
		[onload;file=profile/things.tpl]
		[onload;file=profile/badges.tpl]
	</div>
</div>


<script>
[onshow;block=script;when [profile.id]=[user.user_id]]
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
});
</script>
