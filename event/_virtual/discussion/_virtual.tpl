<div class="cpn-discussion" data-id="[posts.discussion_id;block=div;sub1=comments]">
	<div class="cpn-default">

		<div class="cpn-more cpn-more-invert">
			[onshow;block=div;when [posts.user_id]=[user.user_id]]
			<div class="cpn-more-content">
				<a onclick="popup('[afurl.base]/discussion/delete?id=[posts.discussion_id]')">Delete This Post</a>
			</div>
		</div>

		<a href="[afurl.base]/[posts.user_url;ifempty='[posts.user_id]']"><img src="[posts.thumb_hash;f=cdn]" style="float:left; margin-right:10px; width:75px;height:75px" /></a>

		<div class="b" style="line-height:1em"><a class="cpn-username" href="[afurl.base]/[posts.user_url;ifempty='[posts.user_id]']">[posts.user_name]</a></div>

		<div class="b small" style="line-height:1em"><a style="color:#888; text-decoration:none" href="[afurl.base]/event/[event.event_name;f=urlname]/discussion/[posts.discussion_id]">[posts.discussion_posted;date='W, F lj, Y \a\t g:i A']</div></a>

		<div class="clear"></div>
		<div style="margin-top:10px; color:#636466">[posts.discussion_text]</div>
	</div>


	[onload;file=comment/comments.tpl]


	<div style="font-size:0">
		[onload;block=div;when [user.user_id]!=0]
		<img class="cpn-lfs-reply-post" src="[afurl.static]/glyph-cyan/chat.png" />
		<textarea class="cpn-reply" placeholder="Reply..."></textarea>
	</div>
</div>
