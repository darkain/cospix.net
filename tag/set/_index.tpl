<article class="cpn-default">
	<h1 class="cpn-header">Tag Administration</h1>
	<div class="cpn-default">
		<table>
			<tr>
				<th class="left">Create New Universe</th>
				<td><input id="tag-universe" type="text" style="width:20em" /></td>
				<td><button id="btn-universe">Add</button></td>
			</tr>

			<tr>
				<th class="left">Create New Series</th>
				<td><input id="tag-series" type="text" style="width:20em" /></td>
				<td><button id="btn-series">Add</button></td>
			</tr>

			<tr>
				<th class="left">Create New Character</th>
				<td><input id="tag-character" type="text" style="width:20em" /></td>
				<td><button id="btn-character">Add</button></td>
			</tr>

			<tr>
				<th class="left">Create New Outfit</th>
				<td><input id="tag-outfit" type="text" style="width:20em" /></td>
				<td><button id="btn-outfit">Add</button></td>
			</tr>

			<tr>
				<th class="left">Create New Camera - Software</th>
				<td><input id="tag-software" type="text" style="width:20em" /></td>
				<td><button id="btn-software">Add</button></td>
			</tr>

			<tr>
				<th class="left">Create New Camera - Model</th>
				<td><input id="tag-camera" type="text" style="width:20em" /></td>
				<td><button id="btn-camera">Add</button></td>
			</tr>

			<tr>
				<th class="left">Create New Camera - Lens</th>
				<td><input id="tag-lens" type="text" style="width:20em" /></td>
				<td><button id="btn-lens">Add</button></td>
			</tr>
		</table>
	</div>
</article>

<script>
$('#btn-universe').click(function(){
	$.post(
		'[afurl.base]/tag/set/insert',
		{type:'universe', text:$('#tag-universe').val()},
		function(){ $('#tag-universe').val(''); alert('ADDED!'); }
	);
});

$('#btn-series').click(function(){
	$.post(
		'[afurl.base]/tag/set/insert',
		{type:'series', text:$('#tag-series').val()},
		function(){ $('#tag-series').val(''); alert('ADDED!'); }
	);
});

$('#btn-character').click(function(){
	$.post(
		'[afurl.base]/tag/set/insert',
		{type:'character', text:$('#tag-character').val()},
		function(){ $('#tag-character').val(''); alert('ADDED!'); }
	);
});

$('#btn-outfit').click(function(){
	$.post(
		'[afurl.base]/tag/set/insert',
		{type:'outfit', text:$('#tag-outfit').val()},
		function(){ $('#tag-outfit').val(''); alert('ADDED!'); }
	);
});

$('#btn-software').click(function(){
	$.post(
		'[afurl.base]/tag/set/insert',
		{type:'software', text:$('#tag-software').val()},
		function(){ $('#tag-software').val(''); alert('ADDED!'); }
	);
});

$('#btn-camera').click(function(){
	$.post(
		'[afurl.base]/tag/set/insert',
		{type:'camera', text:$('#tag-camera').val()},
		function(){ $('#tag-camera').val(''); alert('ADDED!'); }
	);
});

$('#btn-lens').click(function(){
	$.post(
		'[afurl.base]/tag/set/insert',
		{type:'lens', text:$('#tag-lens').val()},
		function(){ $('#tag-lens').val(''); alert('ADDED!'); }
	);
});
</script>
