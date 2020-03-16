<main class="cpn-default">
	<h1 class="cpn-header" style="margin-bottom:0.5em; padding:7px 10px">
		[af.title]
	</h1>

	<table class="cpn-folder"><tr>
		<td>[onshow;att=class;attadd;if [cal.year]=2010;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/2010/[cal.month]">2010</a></td>
		<td>[onshow;att=class;attadd;if [cal.year]=2011;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/2011/[cal.month]">2011</a></td>
		<td>[onshow;att=class;attadd;if [cal.year]=2012;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/2012/[cal.month]">2012</a></td>
		<td>[onshow;att=class;attadd;if [cal.year]=2013;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/2013/[cal.month]">2013</a></td>
		<td>[onshow;att=class;attadd;if [cal.year]=2014;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/2014/[cal.month]">2014</a></td>
		<td>[onshow;att=class;attadd;if [cal.year]=2015;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/2015/[cal.month]">2015</a></td>
		<td>[onshow;att=class;attadd;if [cal.year]=2016;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/2016/[cal.month]">2016</a></td>
		<td>[onshow;att=class;attadd;if [cal.year]=2017;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/2017/[cal.month]">2017</a></td>
		<td>[onshow;att=class;attadd;if [cal.year]=2018;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/2018/[cal.month]">2018</a></td>
		<td>[onshow;att=class;attadd;if [cal.year]=2019;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/2019/[cal.month]">2019</a></td>
		<td>[onshow;att=class;attadd;if [cal.year]=2020;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/2020/[cal.month]">2020</a></td>
	</tr></table>

	<table class="cpn-folder"><tr>
		<td>[onshow;att=class;attadd;if [cal.month]=jan;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/[cal.year]/jan">Jan</a></td>
		<td>[onshow;att=class;attadd;if [cal.month]=feb;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/[cal.year]/feb">Feb</a></td>
		<td>[onshow;att=class;attadd;if [cal.month]=mar;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/[cal.year]/mar">Mar</a></td>
		<td>[onshow;att=class;attadd;if [cal.month]=apr;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/[cal.year]/apr">Apr</a></td>
		<td>[onshow;att=class;attadd;if [cal.month]=may;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/[cal.year]/may">May</a></td>
		<td>[onshow;att=class;attadd;if [cal.month]=jun;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/[cal.year]/jun">Jun</a></td>
		<td>[onshow;att=class;attadd;if [cal.month]=jul;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/[cal.year]/jul">Jul</a></td>
		<td>[onshow;att=class;attadd;if [cal.month]=aug;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/[cal.year]/aug">Aug</a></td>
		<td>[onshow;att=class;attadd;if [cal.month]=sep;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/[cal.year]/sep">Sep</a></td>
		<td>[onshow;att=class;attadd;if [cal.month]=oct;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/[cal.year]/oct">Oct</a></td>
		<td>[onshow;att=class;attadd;if [cal.month]=nov;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/[cal.year]/nov">Nov</a></td>
		<td>[onshow;att=class;attadd;if [cal.month]=dec;then 'cpn-folder-selected']<a href="[afurl.base]/calendar/[cal.year]/dec">Dec</a></td>
	</tr></table>


	<h2 class="cpn-header larger" style="padding:5px 7px">
		Submit a New Convention
	</h2>

	<div class="cpn-default" style="padding-bottom:20px">
		<p class="larger justify" style="margin-top:0">
			Cant find the convention you're looking for? Submit it to our online database
			so the rest of the cosplay community can have access to that knowledge too! Click
			the button below to go to the Cospix Convention Submission Form.
		</p>
		<div class="center">
			<a href="[afurl.base]/event/suggest" class="cpn-button largest" style="padding:10px 30px">
				Submit A New Convention
			</a>
		</div>
	</div>

	[onload;file=week.tpl]

</main>

<script>
$('.cpn-folder td').click(function(){
	$(this).closest('tr').find('.cpn-folder-selected').removeClass('cpn-folder-selected');
	$(this).addClass('cpn-folder-selected');
});
</script>
