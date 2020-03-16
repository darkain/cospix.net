<main class="cpn-default cpn-discover">
	<h1 class="cpn-header cpn-discover-header">[badge.badge_name]</h1>
	<div class="cpn-default">

		<div class="larger" style="text-align:justify">
			<img style="float:left;width:200px;height:200px" src="[afurl.static]/badge/[badge.badge_image]" alt="[badge.badge_name]" />
			<div>
				<a href="[afurl.base]/badge/[badges.badge_id]" style="font-size:0;margin:5px">
					<img style="width:100px;height:100px" src="[afurl.static]/badge/[badges.badge_image]" alt="[badges.badge_name;block=a]" />
				</a>
			</div>
			<div style="padding:1em 1em 1em 220px">
				[badge.badge_text]
			</div>
		</div>

		<div class="clear"></div>
	</div>

	<div class="cpn-default cpn-discover">
		<figure>
			<a href="[afurl.base]/[users.user_url;ifempty='[users.user_id]']">
				<img src="[users.img;ifempty='[afurl.static]/thumb2/profile.svg']" alt="[users.user_name]" />
			</a>
			<figcaption>
				<img src="[afurl.static]/thumb2/profile.svg" class="cpn-discover-icon" alt="Profile" />
				<div class="cpn-discover-text">
					<span>[users.badge_timestamp;date=F jS, Y;block=figure;magnet=span]</span>
					<a href="[afurl.base]/[users.user_url;ifempty=[users.user_id]]">
						[users.user_name]
					</a>
				</div>
			</figcaption>
		</figure>

		<div class="clear"></div>
	</div>
</main>
