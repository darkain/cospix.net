<style scoped>
.invites-table {
	width:100%;
}

.invites-table td, .invites-table th {
	border:1px solid #000;
	padding:3px;
}
</style>


<main class="cpn-default" style="width:100%">
	<h1 class="cpn-header">
		<span><a href="[afurl.base]/admin/invites/add">Create New Badge Codes</a></span>
		Invite Codes
	</h1>
	<div class="cpn-default">

		<div class="cpn-loading" style="height:100px"></div>

		<table class="invites-table" style="display:none">
			<thead>
				<tr>
					<th>Invite Code</th>
					<th>Issued By</th>
					<th>Issued On</th>
					<th>Accepted By</th>
					<th>Accepted On</th>
					<th>Badge Type</th>
					<th>Reason</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<th>[invites.code;block=tr]</th>
					<td><a href="[afurl.base]/profile/[invites.invite_sender]">[invites.user_name]</a></td>
					<td class="nobr">[invites.invite_created;date='Y-m-d G:i:s']</td>
					<td><a href="[afurl.base]/profile/[invites.invite_receiver;magnet=a]">[invites.accept_name]</a></td>
					<td class="nobr">[invites.invite_accepted;date='Y-m-d G:i:s']</td>
					<td>[invites.badge_name]</td>
					<td>[invites.invite_reason]</td>
				</tr>
			</tbody>
		</table>
		<div class="clear"></div>
	</div>
</main>




<script>
$(function(){
	$('.cpn-loading').remove();
	$('.invites-table').dataTable({
		'iDisplayLength':500,
		'sPaginationType':'full_numbers',
		'bLengthChange':false,
		'aaSorting':[[2,'desc']],
	}).show();
});
</script>
