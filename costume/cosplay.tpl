<a href="[afurl.base]/[g.user_url;ifempty='[g.user_id]']/costume/[g.gallery_id;block=a]" id="gallery-item-[g.gallery_id]" data-costume-id="[g.gallery_id]" class="cpn-costume">
	<span class="cpn-gallery-move">[onshow;block=span;when [profile.edit;noerr]=1][onshow;block=span;when '[profile.gallery_status;noerr]'='']</span>
	<img src="[g.img;ifempty='[afurl.static]/thumb2/costume.svg']" class="cpn-costume-thumb" alt="[g.gallery_name]" />
	<strong>[g.gallery_name;ifempty='Untitled Costume']</strong>
	<div class="cpn-costume-info">[g.series_label;magnet=div]</div>
	<div class="cpn-costume-info">[g.character_label;magnet=div]</div>
	<div class="cpn-costume-info">[g.outfit_label;magnet=div]</div>
	<div class="cpn-costume-info">TOTAL: [g.total;noerr;magnet=div]</div>
</a>
