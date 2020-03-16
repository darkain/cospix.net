<h1 class="cpn-header">
	Schedule
</h1>

<div class="cpn-default cpn-panel-list">
	<div class="cpn-panel-name">
		<span>
			[panel.schedule_panel_name]
		</span>
	</div>

	<div class="cpn-panel-details">
		<em class="cpn-panel-restrict">
			This is a [panel.schedule_panel_restricted;magnet=em] restricted panel
		</em>
		From <b>[panel.schedule_panel_start;date=g:i A]</b>
		to <b>[panel.schedule_panel_end;date=g:i A]</b>
		on <b>[panel.schedule_panel_start;date=l, F jS]</b>
		<br/>
		Located in
		<b>[panel.schedule_room_name]</b>
		<span> / <b>[panel.schedule_room_text;magnet=span]</b></span>
		<br/><br/>
		<p class="justify">[panel.schedule_panel_text]</p>
	</div>
</div>


<aside class="cpn-default cpn-panel-list">
	<h1 class="cpn-header cpn-discover-header">
		Conflicting Schedules
	</h1>
	<div class="cpn-panel-hour">
		<span class="cpn-panel-time">
			[conflict.schedule_panel_start;date=h:i A;parentgrp=start;block=div]
		</span>
		<div>
			<a href="[afurl.base]/event/[event.event_name;convert=url]/schedule/[conflict.schedule_panel_id]" class="cpn-panel-item cpn-panel-[conflict.schedule_panel_type;ifempty=default]">
				<em class="cpn-panel-restrict">
					[conflict.schedule_panel_restricted;magnet=em]
				</em>
				[conflict.schedule_panel_name;block=a;bmagnet=aside]
			</a>
		</div>
	</div>
</aside>
