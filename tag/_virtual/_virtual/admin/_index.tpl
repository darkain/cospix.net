<section style="margin-left:-13px">

	<div class="profile-box cpn-badge-box">
		<h3 class="cpn-header">
			<span style="float:right" class="small" id="cpn-switch-display">
				Switch Display
			</span>
			Admin
		</h3>
		<div class="profile-box-body">
			<div style="float:left; padding-right:30px">
				Link to a <strong>Universe</strong><br />
				<input type="text" id="cpn-merge-universe" style="width:200px" />
				<input type="button" value="Link" id="cpn-merge-button-universe" />
			</div>

			<div style="float:left; padding-right:30px">
				Link to a <strong>Series</strong><br />
				<input type="text" id="cpn-merge-series" style="width:200px" />
				<input type="button" value="Link" id="cpn-merge-button-series" />
			</div>

			<div style="float:left">
				Link to a <strong>Character</strong><br />
				<input type="text" id="cpn-merge-character" style="width:200px" />
				<input type="button" value="Link" id="cpn-merge-button-character" />
			</div>

			<div class="clear" style="margin-bottom:15px"></div>

			<pre style="float:right; padding-right:15px; color:#aaa">group_id: [tag.group_id]  --  group_type_id: [tag.group_type_id]  --  group_label_id: [tag.group_label_id]  --  language: [tag.lang_id]</pre>


			<div>
				Link to an <strong>Alternate Tags</strong><br />
				<input type="text" id="cpn-merge-tags" style="width:200px" />
				<input type="button" value="Link" id="cpn-merge-button" />
			</div>

			<div class="clear" style="margin-bottom:15px"></div>

			<button style="color:red;float:right" onclick="popup('[afurl.base]/tag/delete?id=[tag.group_label_id]')">Delete Tag</button>
			<div class="clear"></div>
		</div>
	</div>
</section>



<script>
[onshow;block=script;when [profile.edit]=1]
$(function(){
	$('#cpn-merge-tags').autocomplete({
		source: ('[afurl.base]/tag/autocomplete/[tag.group_type_name]'),
		minLength: 1,
	});

	$('#cpn-merge-universe').autocomplete({
		source: ('[afurl.base]/tag/autocomplete/universe'),
		minLength: 1,
	});

	$('#cpn-merge-series').autocomplete({
		source: ('[afurl.base]/tag/autocomplete/series'),
		minLength: 1,
	});

	$('#cpn-merge-character').autocomplete({
		source: ('[afurl.base]/tag/autocomplete/character'),
		minLength: 1,
	});

	$('#cpn-merge-button').click(function(){
		$.post(
			'[afurl.base]/tag/set/group',
			{ id:[tag.group_id], label:$('#cpn-merge-tags').val()},
			refresh
		);
	});

	$('#cpn-merge-button-universe').click(function(){
		$.post(
			'[afurl.base]/tag/set/link',
			{ id:[tag.group_id], type:'universe', label:$('#cpn-merge-universe').val()},
			refresh
		);
	});

	$('#cpn-merge-button-series').click(function(){
		$.post(
			'[afurl.base]/tag/set/link',
			{ id:[tag.group_id], type:'series', label:$('#cpn-merge-series').val()},
			refresh
		);
	});

	$('#cpn-merge-button-character').click(function(){
		$.post(
			'[afurl.base]/tag/set/link',
			{ id:[tag.group_id], type:'character', label:$('#cpn-merge-character').val()},
			refresh
		);
	});

	$('#cpn-switch-display').click(function(){
		$.get('[afurl.base]/tag/set/display',{
			id: [tag.group_id],
			display: ![tag.group_display]
		}, refresh);
	});
});
</script>
