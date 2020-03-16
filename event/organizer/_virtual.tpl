<div class="center largest" style="padding:2em">
	[eventlist;block=div;nodata]
	No events available yet for this organizer
</div>
<article>
	<h2 class="cpn-header larger" style="padding:5px 7px">
		[af.title] - [eventlist.year;block=article;parentgrp=year]
	</h2>
	<div class="cpn-default">


		<ul class="cpn-map-list cpn-tag-list">
			<li itemscope itemtype="http://schema.org/SocialEvent">
				<a itemprop="url" href="[afurl.base]/event/[eventlist.event_name;f=urlname;block=li]">
					<img itemprop="image" src="[eventlist.img;ifempty='[afurl.static]/thumb2/convention.svg']" alt="[eventlist.event_name]" />
					<span>[eventlist.countdown;noerr;magnet=span]</span>
					<strong itemprop="name">[eventlist.event_name]</strong>
					<em>[eventlist.event_location]<br />[eventlist.range]</em>
					<meta itemprop="startDate" content="[eventlist.event_start;date='Y-m-d']" />
					<meta itemprop="endDate" content="[eventlist.event_end;date='Y-m-d']" />
					<span class="noshow" itemprop="location" itemscope itemtype="http://schema.org/Place">
						<meta itemprop="name" content="[eventlist.event_venue]" />
						<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
							<meta itemprop="latitude" content="[eventlist.event_lat]" />
							<meta itemprop="longitude" content="[eventlist.event_lon]" />
						</span>
						<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
							<meta itemprop="addressLocality" content="[eventlist.event_location]" />
						</span>
					</span>
				</a>
			</li>
		</ul>


		<div class="clear"></div>
	</div>
</article>
