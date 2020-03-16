<main class="cpn-default cpn-discover">
	<h1 class="cpn-header">[af.title]</h1>

	<table class="cpn-folder larger"><tr>
		<td><a href="[afurl.base]/[type]">Recently Updated</a></td>
		<td class="cpn-folder-selected"><a href="[afurl.base]/[type]/newest">Newest</a></td>
		<td><a href="[afurl.base]/[type]/total">Most [verb]</a></td>
	</tr></table>

	<div class="cpn-default cpn-discover">
		<figure>
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
