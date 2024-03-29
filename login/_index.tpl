<script>$(function(){$('#cpn-login-redirect').val(document.location)})</script>


<div style="width:760px; max-width:100%; margin:0 auto">
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
