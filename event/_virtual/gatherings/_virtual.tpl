<div class="cpn-profile-left">
	<div class="profile-box">
		<div class="profile-box-body" style="">
			<h2 id="gathering-name">[gathering.gathering_name]</h2>
			<h3 id="gathering-location">[gathering.gathering_location]</h3>
			<div id="gathering-attending">
				[onshow;block=div;when [user.user_id]+-0]
				<button class="cpn-button larger" style="padding:10px 15px">
					[onshow;block=button;when [gathering.attending]!=1]
					+ Attend
				</button>
				<button class="cpn-button larger" style="padding:10px 15px">
					[onshow;block=button;when [gathering.attending]=1]
					- Leave
				</button>
			</div>
		</div>
	</div>

	<div class="profile-box" id="gathering-details">
		<h3 class="cpn-header">Details</h3>
		<p class="large" style="padding:0 10px 10px 10px">[onshow;block=p;when [gathering.host]!=1][gathering.description;safe=no]</p>
		<p title="Click to edit" class="af-edit-field large" style="min-height:4em;padding:0 10px 10px 10px">[onshow;block=p;when [gathering.host]=1][gathering.description;safe=no]</p>
		<textarea class="edit-field af-edit-field" style="display:none;width:100%;min-height:150px">[onshow;block=textarea;when [gathering.host]=1][gathering.gathering_description;safe=nobr]</textarea>
	</div>

	<div class="profile-box">
		<h3 class="cpn-header">Tags</h3>
		<div class="profile-box-body">
			<ul class="cpn-map-list" id="gathering-tags">
				<li><a onclick="popup('[afurl.base]/event/gatherings/tag/create?id=[gathering.gathering_id]', 'Add A New Tag')">
					<img src="[afurl.static]/glyph-cyan/add.png" alt="Add" />
					<strong>Add A New Tag</strong>
				</a></li>
				<li><a href="[afurl.base]/tag/[tags.group_type_name]/[tags.group_label;f=urlname;block=li]"><figure>
					<img src="[afurl.static]/glyph-cyan/close.png" data-label-id="[tags.group_label_id]" class="cpn-tag-unlink" [onshow;block=img;when [user.user_id]=[tags.user_id;noerr]] />
					<img src="[tags.thumb_hash;f=cdn;noerr;ifempty='[afurl.static]/thumb2/[tags.group_type_name;ifempty=blank].svg']" />
					<figcaption>[tags.group_label]</figcaption>
					<em>[tags.group_type_name]</em>
				</figure></a></li>
			</ul>
			<div class="clear"></div>
		</div>
	</div>
</div>


<div class="cpn-profile-right">
	<div class="profile-box">
		<h3 class="cpn-header">Schedule</h3>
		<div class="profile-box-body" id="gathering-calendar" style="padding:0">
			from: [gathering.gathering_start;date='Y-m-d @ H:i:s']
			to: [gathering.gathering_end;date='Y-m-d @ H:i:s']
		</div>
	</div>
</div>

<div class="clear"></div>

<div class="profile-box" style="margin-left:0">
	<div class="profile-box-body">
		<table class="cpn-folder"><tr>
			<td class="cpn-folder-selected">Attending</td><td>Galleries</td>
		</tr></table>

		<div id="gathering-folder">[onload;file=gatherings/attending.tpl]</div>
	</div>
</div>


<script>
$(function() {
	$('.cpn-folder td').click(function(){
		$('.cpn-folder td.cpn-folder-selected').removeClass('cpn-folder-selected');
		$(this).addClass('cpn-folder-selected');

		var txt = $(this).text().trim().toLowerCase();
		$('#gathering-folder').load('[afurl.base]/event/[event.event_id]/gatherings/'+txt+'?id=[gathering.gathering_id]');
	});

	$('#gathering-calendar').html('').fullCalendar({
		theme: true,
		header: { left:'', center:'', right:'' },
		defaultDate: '[gathering.gathering_start;date='Y-m-d']',
		editable: '[gathering.host]',
		defaultView: 'agendaDay',
		slotDuration: '00:15:00',
		height: 300,
		allDaySlot: false,
		scrollTime: '[gathering.gathering_start;date='H:i:s';ope=add:-2700]',
		timezone: false,

		columnFormat: {month:'', week:'', day:'dddd, MMMM Do, YYYY'},

		events: [{
			title: '[gathering.gathering_name;safe=js]',
			start: '[gathering.gathering_start;date='Y-m-d G:i:s']',
			end: '[gathering.gathering_end;date='Y-m-d G:i:s']',
		}],

		eventClick: function() {
			if (!'[gathering.host]') return;
			popup(
				'[afurl.base]/event/gatherings/edit?id=[gathering.gathering_id]',
				'Edit The Day and Time For This Gathering'
			);
		},

		eventResize: function(event) {
			event.start.stripZone();
			event.end.stripZone();
			$.post('[afurl.base]/event/gatherings/time', {
				id: [gathering.gathering_id],
				start: event.start.toISOString(),
				end: event.end.toISOString(),
			});
		},

		eventDrop: function(event) {
			event.start.stripZone();
			event.end.stripZone();
			$.post('[afurl.base]/event/gatherings/time', {
				id: [gathering.gathering_id],
				start: event.start.toISOString(),
				end: event.end.toISOString(),
			});
		},
	});
});
</script>

<script>
[onshow;block=script;when [user.user_id]+-0]
$(function() {
	$('#gathering-attending button').click(function(){
		var txt = $(this).text().trim().toLowerCase();
		txt = txt.replace('+ ', '').replace('- ', '');
		$.post(
			'[afurl.base]/event/gatherings/'+txt,
			{id:[gathering.gathering_id]},
			refresh
		);
	});

	$('img.cpn-tag-unlink').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		$.post(
			'[afurl.base]/event/gatherings/tag/remove',
			{ id:$(this).data('label-id'), item:[gathering.gathering_id] },
			refresh
		);
	});
});
</script>

<script>
[onshow;block=script;when [gathering.host]=1]
$(function() {
	$('#gathering-name').afClickEdit(
		'[afurl.base]/event/gatherings/title',
		[gathering.gathering_id]
	);

	$('#gathering-location').afClickEdit(
		'[afurl.base]/event/gatherings/location',
		[gathering.gathering_id]
	);

	$('#gathering-details p').click(function(){
		$('#gathering-details p').hide();
		$('#gathering-details textarea').show().focus();
	});

	$('#gathering-details textarea').blur(function(){
		$.post(
			'[afurl.base]/event/gatherings/description',
			{ id:[gathering.gathering_id], value:$(this).val() },
			function(data) {
				$('#gathering-details textarea').hide();
				$('#gathering-details p').html(data).show();
			}
		);
	});
});
</script>
