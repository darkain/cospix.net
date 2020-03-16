<article class="cpn-default">
	<h1 class="cpn-header">Gatherings</h1>
	<div class="cpn-default">

		<ul class="cpn-map-list cpn-gathering-list">
			<li id="gathering-add"><a>
				[onshow;block=li;when [user.user_id]+-0]
				<img src="[afurl.static]/img/plus.png" alt="Add a new gathering" />
				<strong>Add a new gathering to</strong>
				[event.event_name]
			</a></li>

			<li><a href="[afurl.base]/event/[event.event_name;f=urlname]/gatherings/[gatherings.gathering_id;block=li]"><figure>
				<img src="[gatherings.img;ifempty='[afurl.static]/thumb2/profile.svg']" alt="[gatherings.gathering_name]" />
				<figcaption>[gatherings.gathering_name]</figcaption>
				<em>[gatherings.gathering_location]<br />[gatherings.gathering_start;date='F jS, Y';noerr]</em>
			</figure></a></li>
		</ul>

		<div class="clear"></div>
	</div>
</article>


<script>
[onshow;block=script;when [user.user_id]+-0]
$(function() {
	$('#gathering-add').click(function(){
		popup('[afurl.base]/event/gatherings/add?id=[event.event_id]', 'Add A Gathering');
	});
});
</script>
