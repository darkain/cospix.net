<article class="cpn-default">

	<h1 class="cpn-header">[af.title]</h1>

	<table class="tablesorter-blue">
		<thead>
			<tr>
				<th>#</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Event Name</th>
				<th>Staff</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>[e.#;block=tr]</td>
				<td>[e.event_start;date='Y-m-d']</td>
				<td>[e.event_end;date='Y-m-d']</td>
				<td><a href="[afurl.base]/event/[e.event_id]">[e.event_name]</a></td>
				<td><a href="[afurl.base]/[e.user_url;ifempty=[e.user_id]]">[e.user_name]</a></td>
			</tr>
		</tbody>
	</table>

</article>

<script>
$(function(){
	$('.tablesorter-blue').tablesorter();
});
</script>
