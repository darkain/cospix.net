<a href="[afurl.base]/profile/costume/[g.gallery_id;block=a]" id="gallery-item-[g.gallery_id]" data-costume-id="[g.gallery_id]" class="cpn-costume">
	<span class="cpn-gallery-move">[onshow;block=span;when [user.user_id]=[profile.user_id;noerr]][onshow;block=span;when '[profile.gallery_status;noerr]'='']</span>
	<img src="[g.img;ifempty='[afurl.static]/thumb2/costume.svg']" class="cpn-costume-thumb" alt="[g.gallery_name]" />
	<b class="cpn-header">[g.gallery_name;ifempty='Untitled Costume']&nbsp;</b>
	<div class="cpn-costume-info">[g.series_label;magnet=div]</div>
	<div class="cpn-costume-info">[g.character_label;magnet=div]</div>
	<div class="cpn-costume-info">[g.outfit_label;magnet=div]</div>
</a>
