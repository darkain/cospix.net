<title>Reset Account Password</title>

<style>
#cpn-register {
	width:370px;
	font-size:2em;
	margin:auto;
}

#cpn-register input {
	display:block;
	width:100%;
	font-size:1em;
	margin-bottom:20px;
	padding:0 4px;
}

#cpn-register .center {
	margin-top:30px;
}

#cpn-register .cpn-button {
	padding:20px;
}
</style>

<main class="cpn-default">
	<h1 class="cpn-header">[af.title]</h1>
	<div class="cpn-default">
		<p class="largest" style="padding:0 1em">
			Type in your email address below and hit the [Reset Password]
			button to have [og.title] generate a new unique password for
			your account. Your new password will be sent to the email address
			provided.
		</p>

		<p class="largest" style="color:red;padding:0 1em">
			[regerror;magnet=p]
		</p>

		<div id="cpn-register">
			<form action="[afurl.all]" method="post"><div>
				<input type="text" name="auth_account"
					placeholder="Email Address" value="[auth_account]"/>

				<input class="cpn-button" type="submit" value="Reset Password"/>
			</div></form>
		</div>
	</div>
</main>
