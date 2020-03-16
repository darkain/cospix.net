<section class="cpn-profile-body">

	<div class="cpn-profile-left">

		<div class="profile-box">
			[onload;block=div;when [profile.edit]=1]
			<h3 class="cpn-header">About [event.event_name]</h3>
			<div class="cpn-default cpn-profile-about">
				<p title="Click to edit" class="af-edit-field">
					[event.description;safe=no]
				</p>
				<textarea class="edit-field af-edit-field">[event.event_description;safe=textarea]</textarea>
			</div>
		</div>

		<div class="profile-box">
			[onload;block=div;when [profile.edit]=0]
			<h3 class="cpn-header">About [event.event_name]</h3>
			<div class="cpn-default">
				[event.description;safe=no;magnet=((div))]
			</div>
		</div>

		<div class="profile-box">
			[onload;block=div;when [profile.edit]=1]
			<h3 class="cpn-header">
				<span onclick="popup('[afurl.base]/event/edit/youtube?id=[event.event_id]','Set YouTube Video')">Edit</span>
				[youtube.youtube_title;noerr]
			</h3>
			<iframe width="517" height="291" src="//www.youtube.com/embed/[youtube.youtube_id;magnet=iframe;noerr]?rel=0&amp;autoplay=0" style="border:0" allowfullscreen></iframe>
			<div class="profile-box-body" itemprop="description">
				[youtube.text;safe=no;noerr]
			</div>
		</div>

		<div class="profile-box" itemscope itemtype="http://schema.org/VideoObject">
			[onload;block=div;when [profile.edit]!=1]
			<h3 class="cpn-header">[youtube.youtube_title;noerr]</h3>
			<meta itemprop="duration" content="T[youtube.youtube_length;date=i;noerr]M[youtube.youtube_length;date=s;noerr]S" />
			<iframe width="517" height="291" src="//www.youtube.com/embed/[youtube.youtube_id;magnet=div;noerr]?rel=0&amp;autoplay=0" style="border:0" allowfullscreen></iframe>
			<div class="profile-box-body" itemprop="description">
				[youtube.text;safe=no;noerr]
			</div>
		</div>


		<div class="profile-box">
			<h3 class="cpn-header">Facebook Feed</h3>
			<div class="profile-box-body">
				<div class="cpn-loading cpn-facebook-feed">
				</div>
				<div class="fb-page center" style="height:500px" data-href="[event.facebook.social_url;noerr;magnet=(((div)))]" data-width="517" data-data-hide-cover="false" data-show-facepile="true" data-show-posts="true"></div>
			</div>
		</div>


		<div class="profile-box">
			<h3 class="cpn-header">
				<span class="cpn-fahrenheit" style="display:none">Fahrenheit</span>
				<span class="cpn-celsius">Celsius</span>
				Weather
			</h3>
			<div class="profile-box-body" style="overflow:hidden">
				<iframe id="forecast_embed" style="border:0;height:210px;width:100%;margin-top:-45px" src="//forecast.io/embed/#lat=[event.event_lat]&amp;lon=[event.event_lon]&amp;color=%2300C8E6&amp;units=[user.weather_unit;noerr;ifempty='us']"></iframe>
			</div>
		</div>


		<div class="cpn-comments" style="margin-left:13px">
			<h4 class="cpn-header">Comments</h4>
			[onload;file=comment/comment.tpl]
			[onload;file=comment/new.tpl]
		</div>
	</div>


	<div class="cpn-profile-right">

		<div class="profile-box cpn-profile-news">
			<h3 class="cpn-header">Local Time</h3>
			<div class="profile-box-body center largest b" style="color:#00c8e6;" id="cpn-event-time">
				[event.localtime;noerr;magnet=((div))]
			</div>
		</div>

		<div class="profile-box">
			<h3 class="cpn-header">Countdown</h3>
			<div class="profile-box-body center largest b" style="color:#00c8e6;">
				[event.event_countdown;magnet=((div))]
			</div>
		</div>

		<div class="profile-box" id="ui-event-date"></div>

		<div class="profile-box" id="ui-event-dateold">
			<h3 class="cpn-header">Dates</h3>
			<div class="profile-box-body">
				Start Date: <time itemprop="startDate" datetime="[event.event_start;date='Y-m-d']">[event.event_start;date='Y-m-d']</time><br />
				End Date: <time itemprop="endDate" datetime="[event.event_end;date='Y-m-d']">[event.event_end;date='Y-m-d']</time>
			</div>
		</div>

		<div class="profile-box">
			[onshow;block=div;when [event.related]+-0]
			<h3 class="cpn-header">Related Events</h3>
			<div class="profile-box-body" style="max-height:400px;overflow-y:auto">
				[onload;file=map/list.tpl]
			</div>
		</div>

		<div class="profile-box">
			<h3 class="cpn-header">Other Events This Weekend</h3>
			<div class="profile-box-body" style="max-height:400px;overflow-y:auto">
				<ul class="cpn-map-list">
					<li itemscope itemtype="http://schema.org/SocialEvent">
						<a itemprop="url" href="[afurl.base]/event/[weekend.event_name;f=urlname;block=li;bmagnet=((div))]">
							<img itemprop="image" src="[weekend.img;ifempty='[afurl.static]/thumb2/convention.svg']" alt="[weekend.event_name]" />
							<span>[weekend.countdown;noerr;magnet=span]</span>
							<strong itemprop="name">[weekend.event_name]</strong>
							<em>[weekend.event_location]<br />[weekend.range]</em>
							<meta itemprop="startDate" content="[weekend.event_start;date='Y-m-d']" />
							<meta itemprop="endDate" content="[weekend.event_end;date='Y-m-d']" />
							<span class="noshow" itemprop="location" itemscope itemtype="http://schema.org/Place">
								<meta itemprop="name" content="[weekend.event_venue]" />
								<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
									<meta itemprop="latitude" content="[weekend.event_lat]" />
									<meta itemprop="longitude" content="[weekend.event_lon]" />
								</span>
								<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
									<meta itemprop="addressLocality" content="[weekend.event_location]" />
								</span>
							</span>
						</a>
					</li>
				</ul>
			</div>
		</div>

	</div>

	<div class="clear"></div>

	<iframe style="opacity:0;height:1px" src="[afurl.base]/event/[event.event_name;f=urlname]/map">
		[onload;block=iframe;when [profile.edit]=1]
		[onshow;block=iframe;when '[event.event_lat]'='0']
		[onshow;block=iframe;when '[event.event_lon]'='0']
	</iframe>

</section>


<div id="fb-root"></div>
<script>
(function(d, s, id) {
	$('#'+id).remove();
	window.FB=null;
	var js, fjs = d.getElementsByTagName(s)[0];
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=[af.config.facebook.id]";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

var fbfixer = setInterval(function(){
	var height = $('.fb_iframe_widget iframe').height();
	if (height == 18) {
		$('.fb_iframe_widget').closest('.profile-box').remove();
		clearInterval(fbfixer);
		$('.cpn-facebook-feed').remove();
	} else if (height === 500) {
		clearInterval(fbfixer);
		$('.cpn-facebook-feed').remove();
	}
}, 100);
</script>


<script>
cpnUpdateTime = function(){
	var ampm	= 'AM';
	var tm		= new Date();
	var tz		= tm.getTimezoneOffset() / 60;
	var h		= (tm.getHours() + tz + [event.timezone]) % 24;
	var m		= tm.getMinutes();
	var s		= tm.getSeconds();

	if (h == 0) h = 12
	if (h > 12) { h -= 12; ampm = 'PM'; }

	$('#cpn-event-time').text( h + ':' + (m<10?'0'+m:m) + ':' + (s<10?'0'+s:s) + ' ' + ampm);
	setTimeout(cpnUpdateTime, 100);
}


$(function() {
	$('#ui-event-dateold').hide();
	$('#ui-event-date').show().datepicker({
		hideIfNoPrevNext: true,
		minDate: '[event.event_start_string]',
		maxDate:'[event.event_end_string]',
		dayNamesMin:['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
	});

	$('.cpn-fahrenheit').click(function(){
		$(this).hide();
		$('.cpn-celsius').show();
		var url = $('#forecast_embed').attr('src').replace('=ca', '=us')
		$('#forecast_embed').attr('src','');
		setTimeout(function(){$('#forecast_embed').attr('src',url);},1);
	});


	$('.cpn-celsius').click(function(){
		$(this).hide();
		$('.cpn-fahrenheit').show();
		var url = $('#forecast_embed').attr('src').replace('=us', '=ca')
		$('#forecast_embed').attr('src','');
		setTimeout(function(){$('#forecast_embed').attr('src',url);},1);
	});

	cpnUpdateTime();
});
</script>


<script>
$(function() {
	$('.cpn-profile-about p').click(function() {
		$(this).hide();
		$('.cpn-profile-about textarea').show().focus();
	});

	$('.cpn-profile-about textarea').blur(function() {
		$.post('[afurl.base]/event/set/description', {
			id:		[event.event_id],
			value:	$(this).val()
		}, function(data) {
			$('.cpn-profile-about textarea').hide();
			$('.cpn-profile-about p').html(data).show();
		});
	});
});
</script>
