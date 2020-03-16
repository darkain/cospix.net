<title>Santa</title>

<style>
section b:nth-child(odd){background:#f00}
section b:nth-child(even){background:#080}
section b {font-size:43px; display:inline-block; text-align:center; width:107px;}
</style>

<article class="cpn-default"><section class="cpn-default"></section></article>

<script>
setInterval(function(){
	$('section.cpn-default').append($('<b>HO </b>'));
}, 250)
</script>
