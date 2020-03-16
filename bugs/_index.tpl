<div style="font-size:2em; padding:1em; background:#e43; color:#237">
	<p>Welcome to the bug reporting page! To report a bug, please copy-paste
	the contents below and fill out the form. Send this information to the
	Rant Master 9001 himself, Vince! Items in the list below with a line,
	please fill them out with the relevant information. If there is any
	item you are unsure of or if it is redundant for your case, feel free
	to leave the item blank.</p>

	<table>
		<tr>
			<th class="left" style="padding:0.1em 0.3em">viewport</th>
			<td class="left" style="padding:0.1em 0.3em" id="bug-viewport"></td>
		</tr>
		<tr>
			<th class="left" style="padding:0.1em 0.3em">[bugs.$;block=tr]</th>
			<td class="left" style="padding:0.1em 0.3em">[bugs.val]</td>
		</tr>
	</table>
</div>


<script>
var bug_viewport = function() {
	$('#bug-viewport').text(
		'W: ' + $(window).width()
		+ ' - ' +
		'H: ' + $(window).height()
	);
}

bug_viewport();
$(window).resize(bug_viewport);
</script>
