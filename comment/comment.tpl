<div class="cpn-comment" data-id="comment-[comment.comment_id;block=div]">
	<a href="[afurl.base]/[comment.user_url;ifempty='[comment.commenter_id]']">
		<img class="cpn-comment-img" src="[comment.img;ifempty='[afurl.static]/thumb2/profile.svg']" alt="[comment.user_name]" />
	</a>

	<div class="cpn-comment-text">
		<a class="cpn-username" href="[afurl.base]/[comment.user_url;ifempty='[comment.commenter_id]']">[comment.user_name]</a>
		[comment.comment_text]
	</div>

	<div class="cpn-comment-status">
		[onshow;block=div;when '[comment.link;noerr]'='']
		[comment.timesince]
	</div>

	<div class="cpn-comment-status">
		[onshow;block=div;when '[comment.link;noerr]'!='']
		<a href="[comment.link;noerr]">[comment.timesince]</a>
	</div>
	<div class="clear"></div>
</div>
