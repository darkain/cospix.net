<main class="cpn-default cpn-discover">
	<h1 class="cpn-header cpn-discover-header">[af.title]</h1>

	<div class="cpn-default cpn-discover">
		<a href="[afurl.base]/[g.user_url;ifempty='[g.user_id]']/[type]/[g.gallery_id]">
			<figure style="width:[g.width;magnet=#]px">
				<img src="[g.img;ifempty='[afurl.static]/thumb2/[type;ifempty=blank].svg']" alt="[g.gallery_name;ifempty='Untitled [type]']" />
				<figcaption>
					<img src="[afurl.static]/thumb2/[type;ifempty=blank].svg" class="cpn-discover-icon" alt="[type]" />
					<div class="cpn-discover-text">
						<span>[g.gallery_name;block=a;ifempty='Untitled [type]']</span>
						<span>[g.user_name;noerr;magnet=span]</span>
					</div>
				</figcaption>
			</figure>
		</a>

		<div class="clear"></div>
	</div>
</main>
