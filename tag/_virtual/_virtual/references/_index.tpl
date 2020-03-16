<article class="cpn-default">
	<h1 class="cpn-header">[af.title]</h1>
	<div class="cpn-default">
		<a class="cpn-thumb-link" onclick="popup('[afurl.full]add','Create A New Image Reference Gallery')"><figure>
			[onshow;block=a;when [profile.edit]=1]
			<figcaption>Create Gallery</figcaption>
			<span class="cpn-thumb-add">+</span>
		</figure></a>

		<a href="[afurl.full][g.gallery_id;block=a]" class="cpn-thumb-link"><figure>
			<img src="[g.img;ifempty='[afurl.static]/thumb2/image.svg']" />
			<figcaption>[g.gallery_name;ifempty='Untitled Gallery']</figcaption>
		</figure></a>
		<div class="clear"></div>
	</div>
</article>
