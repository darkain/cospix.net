<main class="cpn-default cpn-discover">
	<h1 class="cpn-header">[af.title]</h1>

	<table class="cpn-folder larger"><tr>
		<td><a href="[afurl.base]/[type]">Recently Updated</a></td>
		<td><a href="[afurl.base]/[type]/newest">Newest</a></td>
		<td class="cpn-folder-selected"><a href="[afurl.base]/[type]/total">Most [verb]</a></td>
	</tr></table>


	<div class="cpn-default cpn-discover">
		<figure>
			<a href="[afurl.base]/[users.user_url;ifempty='[users.user_id]']">
				<img src="[users.img;ifempty='[afurl.static]/thumb2/profile.svg']" alt="[users.user_name]" />
			</a>
			<figcaption>
				<img src="[afurl.static]/thumb2/profile.svg" class="cpn-discover-icon" alt="Profile" />
				<div class="cpn-discover-text">
					<span>[users.types;block=figure;magnet=span]</span>
					<a href="[afurl.base]/[users.user_url;ifempty=[users.user_id]]">
						[users.user_name]
					</a>
				</div>
			</figcaption>
		</figure>

		<div class="clear"></div>
	</div>
</main>
