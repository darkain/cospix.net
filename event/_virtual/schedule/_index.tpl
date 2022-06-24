<h1 class="cpn-header">Schedule</h1>
<div class="cpn-default cpn-panel-list">
	<div class="center">
		[onshow;block=div;when [profile.edit]=1]
		<a href="[afurl.all]/editor" class="cpn-button" target="_blank" style="padding:10px">
			Open Schedule Editor
		</a>
	</div>
	<div class="cpn-panel-day">
		<a class="cpn-anchor" id="day-[panel.day;f=lower]"></a>
		<span>[panel.day;parentgrp=day;block=div]</span>
		<div class="cpn-panel-hour">
			<a class="cpn-anchor" id="time-[panel.schedule_panel_start]"></a>
			<span class="cpn-panel-time">
				[panel.schedule_panel_start;date=h:i A;parentgrp=start;block=div]
			</span>
			<div>
				<a href="[afurl.base]/event/[event.event_name;convert=url]/schedule/[panel.schedule_panel_id]-[panel.schedule_panel_name;f=urlid]" class="cpn-panel-item cpn-panel-[panel.schedule_panel_type;ifempty=default]">
					<em class="cpn-panel-restrict">
						[panel.schedule_panel_restricted;magnet=em]
					</em>
					[panel.schedule_panel_name;block=a]
				</a>
			</div>
		</div>
	</div>
</div>
