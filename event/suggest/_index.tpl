<main class="cpn-default">
	<h1 class="cpn-header">[af.title]</h1>

	<form id="frm-submit-event" method="post" action="[afurl.base]/event/suggest/submit">
		<div class="cpn-default">

			<table><tr><td style="vertical-align:top; padding:1em" rowspan="2" class="large">

				<b>Convention Name:</b><br />
				<input value="" type="text" name="name" style="width:25em" /><br /><br />

				<b>Location:</b> <i>(city, state/prov, country)</i><br />
				<input value="" type="text" name="location" style="width:25em" /><br /><br />

				<b>Venue Name:</b> <i>(convention center, hotel, etc)</i><br />
				<input value="" type="text" name="venue" style="width:25em" /><br /><br />

				<b>Web Site URL:</b><br />
				<input value="" type="text" name="site" style="width:25em" /><br /><br />

				<b>Facebook:</b> <i>(optional)</i><br />
				<input value="" type="text" name="facebook" style="width:25em" /><br /><br />

				<b>Twitter:</b> <i>(optional)</i><br />
				@<input value="" type="text" name="twitter" style="width:24em" /><br /><br />


			</td><td style="vertical-align:top; padding:1em;height:250px">
				<div id="new-event-from"><b>Start Date: <input type="hidden" name="start" id="new-event-start"  style="width:8em" /></b></div>
			</td><td style="vertical-align:top; padding:1em">
				<div id="new-event-to"><b>End Date: <input type="hidden" name="end" id="new-event-end"  style="width:8em" /></b></div>
			</td></tr>

			<tr><td colspan="2" class="large">
				<b>Additional Notes:</b><br />
				<textarea name="data" style="width:100%"></textarea>
			</td></tr>

			</table>

			<div class="center">
				<input type="submit" class="cpn-button"
					style="padding:20px 30px; font-size:20px"
					value="Submit This Convetion" />
			</div>
		</div>
	</form>

</main>
