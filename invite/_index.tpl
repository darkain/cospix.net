<style>
p{font-size:20px;}
.cpn-invite-code {font-size:20px; font-family:monospace; text-align:center;}
</style>

<article class="cpn-default">
	<h1 class="cpn-header">Invite A Friend</h1>
	<section class="cpn-default">
		<p>
			You can generate one invite code each day. You're free to give out these invite codes any way you see fit!
			Share them with friends. Host giveaways contests. surprise a random stranger. Transmit them through the
			air via smoke signal!
		</p>

		<div id="cpn-invite-code-list">
			[onload;file=codes.tpl]
		</div>

		<div class="center">
			<button id="cpn-generate-code">Generate New Code</button>
		</div>
	</section>
</article>

<script>
$('#cpn-generate-code').click(function(){
	$('#cpn-invite-code-list').load('[afurl.base]/invite/generate');
});
</script>
