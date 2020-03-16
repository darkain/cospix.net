<script>$(function(){$('#cpn-login-redirect').val(document.location)})</script>

<style>
#prometheus-login {
	display:flex;
	flex-wrap:wrap;
	padding:0 1em;
}

body #cpn-login-email,
body #cpn-login-services,
body #prometheus-login>div {
	float:none;
	padding:0;
	margin:1em 0;
	font-size:1.5em;
	flex-grow:1;
	flex-shrink:0;
	width:100%;
}

#prometheus-login svg,
#prometheus-login input,
#prometheus-login a {
	font-size:1em;
	display:block;
	width:100%;
	max-width:100%;
	padding:0;
	margin:0.5em 0;
}

#prometheus-login input {
	padding:0.35em 0.5em;
	border:1px solid #888;
}

#prometheus-login .cpn-button {
	padding:0.35em 0;
	width:100%;
	height:2em;
}
</style>


<div style="width:760px; max-width:100%; margin:0 auto">
	<div class="justify large" style="padding:1em">
		Select your login service. If you already have an account with
		Cospix, please use the same login service that you used when registering
		your Cospix account. If you don't already have an account, signing in
		using Facebook, Google, or Twitter will automatically create a Cospix
		account for you!
	</div>

	<div id="prometheus-login">
		<div id="cpn-login-email">
			<form action="https://[afurl.domain][afurl.base]/login/auth"
				method="post"><div>

				<input type="email" name="auth_account"
					placeholder="Email Address"/>

				<input type="password" name="auth_password"
					placeholder="Password" autocomplete="off"/>

				<input type="hidden" name="redirect" id="cpn-login-redirect"/>

				<input class="cpn-button" type="submit" value="Login"/>

			</div></form>
		</div>

		<div id="cpn-login-services">
			<a href="[afurl.host][afurl.base]/login/facebook">
				[onshow;svg=static/svg/login-facebook.svg]
			</a>

			<a href="[afurl.host][afurl.base]/login/google">
				[onshow;svg=static/svg/login-google.svg]
			</a>

			<a href="[afurl.host][afurl.base]/login/twitter">
				[onshow;svg=static/svg/login-twitter.svg]
			</a>
		</div>

		<div class="center">
			<a href="[afurl.base]/login/register" class="cpn-button">Create A New Account</a>
			<a href="[afurl.base]/login/reset" class="cpn-button">I Forgot My Password</a>
		</div>
	</div>

	<div class="clear"></div>

	<div class="justify" style="margin:20px auto 0 auto; padding:1em">
		By signing into the Cospix.net web site, you are agreeing to the terms and conditions set forth in our <a target="_blank" href="[afurl.base]/legal/privacy">Privacy Policy</a> and <a target="_blank" href="[afurl.base]/legal/tos">Terms of Service</a>.
	</div>
</div>
