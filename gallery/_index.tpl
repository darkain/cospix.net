<main class="cpn-default cpn-discover">
	<h1 class="cpn-header cpn-discover-header">[af.title]</h1>

	<div class="cpn-default cpn-discover">
		<figure style="width:[g.width;magnet=#]px">
			<a href="[afurl.base]/[g.user_url;ifempty='[g.user_id]']/[type]/[g.gallery_id]">
				<img src="[g.img;ifempty='[afurl.static]/thumb2/[type;ifempty=blank].svg']" alt="[g.gallery_name;ifempty='Untitled [type]']" />
			</a>
			<figcaption>
				<img src="[afurl.static]/thumb2/[type;ifempty=blank].svg" class="cpn-discover-icon" alt="[type]" />
				<div class="cpn-discover-text">
					<span>[g.gallery_name;block=figure;ifempty='Untitled [type]']</span>
					<a href="[afurl.base]/[g.user_url;ifempty=[g.user_id;noerr];noerr]">
						[g.user_name;noerr;magnet=a]
					</a>
				</div>
			</figcaption>
		</figure>

		<div class="clear"></div>
	</div>
</main>
