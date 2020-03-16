<form action="[afurl.upload]" class="cpn-dropzone" method="post" enctype="multipart/form-data">
	<div class="cpn-gallery-sortable">
		<input type="hidden" name="gallery_id" value="[gallery.gallery_id;noerr;magnet=input]" />
		<input type="hidden" name="event_id" value="[gallery.event_id;noerr;magnet=input]" />

		<a class="cpn-thumb-link" id="cpn-gallery-add-images"><figure>
			[onshow;block=a;when [profile.edit;noerr]=1]
			<span class="cpn-thumb-add">+</span>
			<figcaption>Add photos to this [gallery.gallery_type;noerr;magnet=a]</figcaption>
		</figure></a>

		<a id="gallery-item-[g.file_hash;f=hex]" href="[afurl.base]/image/[g.file_hash;f=hex;block=a]?gallery=[g.gallery_id]" class="cpn-thumb-link" itemscope itemtype="http://schema.org/ImageObject" itemprop="associatedMedia"><figure>
			<img src="[g.img;ifempty='[afurl.static]/thumb2/image.svg']" itemprop="thumbnailUrl" alt="Image [g.file_hash;f=hex]" />
			<span class="cpn-gallery-move">[onshow;block=span;when [profile.edit;noerr]=1]</span>
			<figcaption>
				<span><em class="chatpng"></em> [g.file_comments;magnet=span]</span>
				<span><em class="userpng"></em> [g.file_credits;magnet=span]</span>
				<span><em class="favoritepng"></em> [g.file_favorites;magnet=span]</span>
				<span><em class="viewpng"></em> [g.file_views;magnet=span]</span>
			</figcaption>
		</figure></a>
	</div>
</form>
