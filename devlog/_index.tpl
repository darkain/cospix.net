<style scoped>
.cpn-dev-log { padding:20px 10px 10px 10px; }

.cpn-dev-log div {
	margin-bottom:20px;
	background:#f8f8f8;
	padding:5px 10px;
	font-size:1.5em;
}

.cpn-dev-log h2 {
	padding:15px 0 5px 5px;
}

.cpn-dev-log h3 {
	font-size:1em;
	font-weight:bold;
	margin:7px 0;
	color:#00C8E6;
}

.cpn-dev-log h3 a {text-decoration:none}

.cpn-dev-log div span {display:block;}

#cpn-new-devlog textarea {
	width:100%;
	height:4em;
	margin-top:5px;
}
</style>


<article class="cpn-default">
	<h1 class="cpn-header">[af.title] for [og.title]</h1>

	<div class="cpn-dev-log">
		<div id="cpn-new-devlog" class="right">
			[onshow;block=div;when [user.permission.admin]=1]
			<textarea name="text"></textarea>
			<input type="button" value="Post!" />
		</div>

		<section>
			<h2>[log.ym;block=section;parentgrp=ym]</h2>
			<div data-id="[log.log_id;block=div]">
				<h3>
					Posted on
					[log.log_time;date='Y-m-d \a\t H:i:s']
					by
					<a href="[afurl.base]/[log.user_url;ifempty=[log.user_id]]">[log.user_name]</a>
				</h3>
				<span>[log.log_text;safe=no]</span>
			</div>
		</section>
	</div>

	<div class="clear"></div>
</article>


<script>
[onshow;block=script;when [user.permission.admin]=1]
$(function(){
	$('.cpn-dev-log div span').afClickEdit(
		'[afurl.base]/devlog/update', 'id'
	);

	$('#cpn-new-devlog input').click(function(){
		$.post(
			'[afurl.base]/devlog/insert',
			$('#cpn-new-devlog').afSerialize(),
			refresh
		);
	});
});
</script>
