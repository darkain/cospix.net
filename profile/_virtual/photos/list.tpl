<a id="gallery-item-[g.file_hash;f=hex]" href="[afurl.base]/image/[g.file_hash;f=hex;block=a]?gallery=[g.gallery_id]" class="cpn-thumb-link" data-id="[g.file_hash;f=hex]" data-time="[g.user_time]"><figure>
	<img src="[g.img;ifempty='[afurl.static]/thumb2/image.svg']" />
	<span class="cpn-credit-delete" onclick="cpn_credit_delete(event, this)">[onshow;block=span;when [user.user_id]=[user.user_id]]</span>
	<span class="cpn-credit-add-gallery" onclick="cpn_credit_addgallery(event, this)">[onshow;block=span;when [user.user_id]=[user.user_id]]</span>
	<figcaption>[g.gallery_name]</figcaption>
</figure></a>
<div class="clear"></div>
