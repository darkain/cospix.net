<section class="cpn-default cpn-feed-item" data-id="[feed.activity_id]" data-time="[feed.activity_timestamp]">
	<div class="cpn-feed-body">
		<a href="[afurl.base]/[feed.user_url;ifempty='[feed.user_id]']" class="cpn-activity-image"><img src="[feed.url;noerr;ifempty='[afurl.static]/thumb2/profile.svg']" alt="[feed.name]" /></a>
		<h5>
			<a href="[afurl.base]/[feed.user_url;ifempty='[feed.user_id]']">[feed.user_name]</a>
			[feed.activity_verb;block=section;sub1=recommend]
			<a href="[afurl.base][feed.link]">[feed.name]</a>
			[feed.extra_text;noerr]
		</h5>
		<div class="cpn-feed-since">[feed.since]</div>

		<div class="clear"></div>

		<div>[feed.text;noerr;magnet=div]</div>
		<div>[feed.template;noerr;safe=no;magnet=div]</div>

		<div class="clear"></div>
		<div style="margin-top:5px; padding-top:5px; border-top:1px solid #f0f0f0">
			<a href="[afurl.base]/tag/[feed_sub1.group_type_name]/[feed_sub1.group_label;f=url]" style="display:inline-block;margin-right:20px">
				<img src="[feed_sub1.img;ifempty='[afurl.static]/thumb2/[feed_sub1.group_type_name;ifempty=blank].svg']" style="width:25px;height:25px; vertical-align:middle" alt="[feed_sub1.group_type_name]" />
				[feed_sub1.group_label;block=a;bmagnet=div]
			</a>
		</div>
	</div>

	<div style="margin-top:-10px">[feed.comments;noerr;safe=no;magnet=div]</div>

	<div class="clear">&nbsp;</div>
</section>
