<main class="cpn-default">

	<h1 class="cpn-header">[af.title]</h1>

	<table class="tablesorter-blue">
		<thead>
			<tr>
				<th class="right">#</th>
				<th class="right">ID</th>
				<th class="right">Gp</th>
				<th>Add</th>
				<th class="center">Start Date</th>
				<th class="center">End Date</th>
				<th>Event Name</th>
				<th>City</th>
				<th>Total</th>
				<th class="center">URL</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td class="right">[e.#;block=tr]</td>
				<td class="right">[e.event_id]</td>
				<td class="right">[e.event_group]</td>
				<td class="nobr"><a href="[afurl.base]/[e.user_url;ifempty='[e.user_id;noerr]']">[e.user_name;noerr]</a></td>
				<td class="nobr center"><a href="[afurl.base]/calendar/[e.event_start;f=urldate]">[e.event_start;date='Y-m-d']</a></td>
				<td class="nobr center">[e.event_end;date='Y-m-d']</td>
				<td class="b"><a href="[afurl.base]/event/[e.event_id]">[e.event_name]</a></td>
				<td>[e.event_location]</td>
				<td>[e.total;noerr]</td>
				<td class="center"><a href="[e.event_website;magnet=a]" target="_blank">LINK</a></td>
			</tr>
		</tbody>

		<tfoot>
			<tr>
				<th class="right">#</th>
				<th class="right">ID</th>
				<th class="right">Gp</th>
				<th>Add</th>
				<th class="center">Start Date</th>
				<th class="center">End Date</th>
				<th>Event Name</th>
				<th>City</th>
				<th>Total</th>
				<th class="center">URL</th>
			</tr>
		</tfoot>
	</table>

</main>
