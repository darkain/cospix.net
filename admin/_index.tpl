<style scoped>
.tbldates th, .tbldates td { text-align:right; width:2em; }
.tbldates th { width: 6em; }
main.cpn-default {
	font-size:2em;
}
</style>

<main class="cpn-default">

	<div style="width:48%; float:right">
		<h1 class="cpn-header">Event Administration</h1>
		<section class="cpn-default largest">
			<a href="[afurl.base]/event/reports">This section has MOVED!</a>
		</section>
	</div>


	<div style="width:48%">
		<h1 class="cpn-header">User Administration</h1>
		<section class="cpn-default">
			<table>
				<tr>
					<td class="right">Total Users</td>
					<td>[a.user.total]</td>
				</tr>
				<tr>
					<td class="right">Activated Users</td>
					<td>[a.user.active]</td>
				</tr>
				<tr>
					<td class="right"><a href="[afurl.base]/admin/invites">Invite Codes</a></td>
					<td>[a.user.invite]</td>
				</tr>
				<tr>
					<td class="right"><a href="[afurl.base]/admin/comments">Recent User Comments</a></td>
					<td></td>
				</tr>
			</table>
		</section>


		<h1 class="cpn-header">Tags</h1>
		<section class="cpn-default">
			<ul style="margin:0; padding:0; list-style-type:none">
				<li><a target="_blank" href="[afurl.base]/tag">Tags Home</a></li>
				<li><a target="_blank" href="[afurl.base]/tag/set">Tags Admin</a></li>
			</ul>
		</section>

		<h1 class="cpn-header">Other Resources</h1>
		<section class="cpn-default">
			<ul style="margin:0; padding:0; list-style-type:none">
				<li><a target="_blank" href="[afurl.base]/admin/status">Server Status</a></li>
				<li><a target="_blank" href="[afurl.base]/admin/phpinfo">PHP Info</a></li>
			</ul>
		</section>

		<h1 class="cpn-header">YouTube Admin</h1>
		<section class="cpn-default">
			<ul style="margin:0; padding:0; list-style-type:none">
				<li><a target="_blank" href="[afurl.base]/admin/youtube/add">Add Tutorials</a></li>
			</ul>
		</section>
	</div>

	<div class="clear"></div>

</main>
