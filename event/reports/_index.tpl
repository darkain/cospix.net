<main class="cpn-default">
	<h1 class="cpn-header">Total Events by Year</h1>

	<div id="event-graph" class="cpn-default">
		<svg>
			<a href="[afurl.base]/event/reports/year/[dates.$]">
				<rect data-val="[dates.val;block=a;p1]"></rect>
			</a>
		</svg>

		<table>
			<tr>
				<td>
					<a href="[afurl.base]/event/reports/year/[dates.$]">
						[dates.val;block=td;p1]
					</a>
				</td>
			</tr>
			<tr>
				<td>
					<a href="[afurl.base]/event/reports/year/[dates.$]">
						[dates.$;block=td;p1]
					</a>
				</td>
			</tr>
		</table>
	</div>


	<div class="clear" style="margin-top:40px"></div>
	<h1 class="cpn-header">Events Missing Dates</h1>
	<div class="cpn-default cpn-event-reports">
		<table>
			<tr>
				<td>
					<a href="[afurl.base]/event/reports/missing/[dates.$]">
						[dates.$;block=td;p1]
					</a>
				</td>
			</tr>
		</table>
	</div>


	<div class="clear" style="margin-top:40px"></div>
	<h1 class="cpn-header">Other Reports</h1>
	<div class="cpn-default largest">
		<table>
			<tr>
				<td class="right"><a href="[afurl.base]/event/new">Create A New Event</a></td>
				<td rowspan="12" style="width:20px"></td>
				<td class="smallest i">Note: If you're adding a new year to an existing event,<br/>use that event's page instead of this method</td>
			</tr>
			<tr>
				<td class="right"><a href="[afurl.base]/event/reports/recent">Recently Added Events</a></td>
				<td></td>
			</tr>
			<tr>
				<td class="right"><a href="[afurl.base]/event/reports/all">List All Events</a></td>
				<td>[report.all]</td>
			</tr>
			<tr>
				<td class="right"><a href="[afurl.base]/event/reports/nourl">Events without URLs</a></td>
				<td>[report.nourl]</td>
			</tr>
			<tr>
				<td class="right"><a href="[afurl.base]/event/reports/notwitter">Events without Twitter</a></td>
				<td>[report.notwitter]</td>
			</tr>
			<tr>
				<td class="right"><a href="[afurl.base]/event/reports/nofacebook">Events without Facebook</a></td>
				<td>[report.nofacebook]</td>
			</tr>
			<tr>
				<td class="right"><a href="[afurl.base]/event/reports/noyoutube">Events without YouTube</a></td>
				<td>[report.noyoutube]</td>
			</tr>
			<tr>
				<td class="right"><a href="[afurl.base]/event/reports/novideo">Events without a Video</a></td>
				<td>[report.novideo]</td>
			</tr>
			<tr>
				<td class="right"><a href="[afurl.base]/event/reports/nopic">Events without an Icon</a></td>
				<td>[report.noimage]</td>
			</tr>
			<tr>
				<td class="right"><a href="[afurl.base]/event/reports/nogeo">Events without Geolocation</a></td>
				<td>[report.nogeo]</td>
			</tr>
			<tr>
				<td class="right"><a href="[afurl.base]/event/reports/nodate">Events without Dates</a></td>
				<td>[report.nodate]</td>
			</tr>
			<tr>
				<td class="right"><a href="[afurl.base]/event/reports/canceled">Canceled Events</a></td>
				<td>[report.canceled]</td>
			</tr>
		</table>
	</div>

</main>
