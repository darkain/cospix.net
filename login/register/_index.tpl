<title>Register A New Account</title>

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
			Please enter your email address and a unique password below to
			register for a new [og.title] account. If you already have an
			account, then please use the [Login] button at the top of this page
			instead of this form.
		</p>

		<p class="largest" style="padding:0 1em">
			Passwords must be at least [minpass] characters long.
		</p>

		<p class="largest" style="color:red;padding:0 1em">
			[regerror;magnet=p]
		</p>

		<div id="cpn-register">
			<form action="https://[afurl.domain][afurl.base]/login/register"
				method="post"><div>

				<input type="email" name="auth_account"
					placeholder="Email Address" value="[auth_account]" />

				<input type="password" name="auth_password"
					autocomplete="off" placeholder="Password"/>

				<input type="password" name="auth_confirm"
					autocomplete="off" placeholder="Confirm Password"/>

				<input type="hidden" name="redirect" id="cpn-login-redirect"/>


				<button class="g-recaptcha cpn-button"
					data-sitekey="[af.config.recaptcha.key]"
					data-callback="af_register">
					Register
				</button>

			</div></form>
		</div>
	</div>
</main>

<script>
af_register = function() {
	$('#cpn-register form').submit();
}
</script>
<script src="https://www.google.com/recaptcha/api.js"></script>
