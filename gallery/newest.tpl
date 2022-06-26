<main class="cpn-default cpn-discover">
	<h1 class="cpn-header">[af.title]</h1>

	<table class="cpn-folder larger"><tr>
		<td><a href="[afurl.base]/[type]">Recently Updated</a></td>
		<td class="cpn-folder-selected"><a href="[afurl.base]/[type]/newest">Newest</a></td>
		<td><a href="[afurl.base]/[type]/total">Most [verb]</a></td>
	</tr></table>

	<div class="cpn-default cpn-discover">
		<a href="[afurl.base]/[g.user_url;ifempty='[g.user_id]']/[type]/[g.gallery_id]">
			<figure>
				<img src="[g.img;ifempty='[afurl.static]/thumb2/[type;ifempty=blank].svg']" alt="[g.gallery_name;ifempty='Untitled [type]']" />
				<figcaption>
					<img src="[afurl.static]/thumb2/[type;ifempty=blank].svg" class="cpn-discover-icon" alt="[type]" />
					<div class="cpn-discover-text">
						<span>[g.gallery_name;block=a;ifempty='Untitled [type]']</span>
						<span>[g.user_name;noerr;magnet=span]
					</div>
				</figcaption>
			</figure>
		</a>

		<div class="clear"></div>
	</div>
</main>
