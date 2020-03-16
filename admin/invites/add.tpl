<style scoped>
th {text-align:left}

label {
	display:inline-block;
	width:200px;
	height:225px;
	overflow:hidden;
	text-overflow:ellipsis;
	font-size:14px;
	text-align:center;
	margin:5px;
	cursor:pointer;
}

label img {
	width:200px;
	height:200px;
}

label:hover img { opacity:0.8; }

label input { position:absolute; }
</style>

<main class="cpn-default">
	<h1 class="cpn-header">[af.title]</h1>
	<div class="cpn-default largest">
		<table id="new-badges">

			<tr>
				<th class="top" style="padding-right:30px">Badge</th>
				<td>
					<label>
						<input type="radio" name="id" value="[badge.badge_id]" />
						<img src="[afurl.static]/badge/[badge.badge_image]" alt="[badge.badge_name]" />
						[badge.badge_name;block=label]
					</label>
				</td>
			</tr>

			<tr><td></td><td class="smallest">&nbsp;</td></tr>

			<tr>
				<th>Qty</th>
				<td>
					Create <input name="total" type="text" placeholder="0" value="1" style="width:2em" class="right" /> badge codes
				</td>
			</tr>

			<tr><td></td><td class="smallest">&nbsp;</td></tr>

			<tr>
				<th>Reason</th>
				<td>
					<input name="reason" type="text" placeholder="Optional Text..." style="width:100%" />
				</td>
			</tr>

			<tr>
				<th></th>
				<td style="padding:30px">
					<button class="cpn-button largest" style="padding:30px;width:100%">Create Badges</button>
				</td>
			</tr>

		</table>

		<div id="new-badge-out"></div>
	</div>
</main>

<script>
$('#new-badges button').click(function(){
	$('#new-badge-out').load(
		'[afurl.base]/admin/invites/insert',
		$('#new-badges').afSerialize()
	);
});
</script>
