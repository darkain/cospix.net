<a href="[afurl.base]/[g.user_url;ifempty='[g.user_id]']/costume/[g.gallery_id;block=a]" id="gallery-item-[g.gallery_id]" data-costume-id="[g.gallery_id]" class="cpn-costume" style="height:50px;margin:0 0 5px 0">
	<span class="cpn-gallery-move">[onshow;block=span;when [profile.edit;noerr]=1][onshow;block=span;when '[profile.gallery_status;noerr]'='']</span>
	<img src="[g.img;ifempty='[afurl.static]/thumb2/costume.svg']" class="cpn-costume-thumb" alt="[g.gallery_name]" style="width:50px;height:50px" />
	<b style="display:block;padding-left:55px; white-space:nowrap">[g.gallery_name;ifempty='Untitled Costume']&nbsp;</b>
	<span style="display:block; margin-left:55px">[g.user_name]</span>
</a>
