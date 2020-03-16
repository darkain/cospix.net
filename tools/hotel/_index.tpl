<article class="cpn-default">
	<h1 class="cpn-header">
		<a href="[afurl.base]/tools">Tools</a>
		&raquo; [af.title]
	</h1>

	<div class="cpn-default">

		<div class="large" style="padding:0.5em">
			<span style="float:right">Share This: <input type="text" id="tool-hotel-share" onclick="this.select();" /></span>
			Total Hotel Cost: $<input type="text" id="total" value="[data.total;noerr]" />
		</div>

		<table id="tool-hotel">
			<thead>
				<tr>
					<th style="width:2em">#</th>
					<th>Roommate Names</th>
					<th>Wed<div id="day-0" class="small"></div></th>
					<th>Thur<div id="day-1" class="small"></div></th>
					<th>Fri<div id="day-2" class="small"></div></th>
					<th>Sat<div id="day-3" class="small"></div></th>
					<th>Sun<div id="day-4" class="small"></div></th>
					<th>Mon<div id="day-5" class="small"></div></th>
					<th>Tue<div id="day-6" class="small"></div></th>
					<th>Subtotal</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<th>[block.#;block=tr]</th>
					<th><input id="nnn[block.$]" type="text" style="width:100%" value="[data.name.[block.#];noerr]" /></th>
					<td class="hotel-day"><input type="checkbox" [data.check[block.#].0;noerr;att=checked;atttrue=1]/></td>
					<td class="hotel-day"><input type="checkbox" [data.check[block.#].1;noerr;att=checked;atttrue=1]/></td>
					<td class="hotel-day"><input type="checkbox" [data.check[block.#].2;noerr;att=checked;atttrue=1]/></td>
					<td class="hotel-day"><input type="checkbox" [data.check[block.#].3;noerr;att=checked;atttrue=1]/></td>
					<td class="hotel-day"><input type="checkbox" [data.check[block.#].4;noerr;att=checked;atttrue=1]/></td>
					<td class="hotel-day"><input type="checkbox" [data.check[block.#].5;noerr;att=checked;atttrue=1]/></td>
					<td class="hotel-day"><input type="checkbox" [data.check[block.#].6;noerr;att=checked;atttrue=1]/></td>
					<th class="hotel-sub" id="sub-[block.#]"></th>
				</tr>
			</tbody>
		</table>

		<div style="padding-top:2em">
			NOTE: This tool is simply to help calculate the cost of
			splitting a hotel room between multiple people. You are
			still responsible for the accuracy of your own information,
			including hotel total costs (<i>don't forget about fees and
			taxes</i>), as well as payments to your hotel stay.
		</div>
	</div>
</article>

<script>
var pagehash = '[page.hash;f=hex;noerr]';

hotelcalc = function() {
	var total = parseFloat( $('#total').val() );
	var cols = [0,0,0,0,0,0,0];
	var days = 0;
	var data = {'hash':pagehash, 'total':total, 'n':{}};

	for (var i=0;i<7;i++) {
		$('#tool-hotel tbody tr td:nth-child('+(i+3)+')').each(function(idx,item){
			if ($(item).hasClass('checked')) {
				if (cols[i] == 0) days++;
				cols[i]++;
			}
		});
	}

	var rate = total / days;

	for (var i=0;i<7;i++) {
		if (total  &&  days  &&  cols[i]) {
			$('#day-'+i).text('$' + rate.toFixed(2));
		} else {
			$('#day-'+i).text('$0.00');
		}
	}

	for (var i=1; i<=10; i++) {
		var val = $('#nnn'+(i-1)).val().trim();
		if (val != '') data['n'][i] = val;
		data['c'+i] = {};

		var subtotal = 0;
		for (var x=0;x<7;x++) {
			if ($('#tool-hotel tbody tr:nth-child('+i+') td:nth-child('+(x+3)+')').hasClass('checked')) {
				if (total  &&  days) subtotal += (rate / cols[x]);
				data['c'+i][x] = 1;
			}
		}

		$('#sub-'+i).text('$' + subtotal.toFixed(2));
	}


	$.post('[afurl.base]/tools/hotel/save', data, function(pagehash){
		pagehash = pagehash.trim();
		console.log(pagehash);
		if (!pagehash.match(/^[0-9A-F]{32}$/i)) return;
		History.replaceState({}, document.title, '[afurl.base]/[router.part.1]/[router.part.2]?hash='+pagehash);
		$('#tool-hotel-share').val(document.location).show();
	});
}



$(function(){
	var inclick = false;

	$('#total').change(hotelcalc);
	$('#tool-hotel th input').change(hotelcalc);

	$('#tool-hotel td').click(function(event){
		if (inclick) return;
		inclick = true;

		event.stopPropagation();
		event.preventDefault();
		console.log(this);
		$(this).find('input').click();
		$(this).toggleClass('checked', $(this).find('input').prop('checked'));
		hotelcalc();

		inclick = false;
	});

	$('input:checked').parent().addClass('checked');
	hotelcalc();
});
</script>
