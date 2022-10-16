<div id="cospix-message-list"></div>
<div id="prometheus-menu-background"></div>


<nav id="prometheus-sidebar">
	<a id="prometheus-sidebar-menu">
		[onshow;svg=static/svg/hamburger.svg]
	</a>

	<a href="[afurl.base]/" id="cospix-logo-mobile">
		[onshow;svg=static/svg/cospix.svg]
	</a>

	<div id="prometheus-sidebar-links">

		<a href="[afurl.base]/" id="cospix-logo">
			[onshow;svg=static/svg/cospix.svg]
		</a>



		<a href="[afurl.base]/login">
			[onshow;block=a;when [user.user_id]=0]
			[onshow;svg=static/svg/profile.svg]
			<span>Login / Sign up</span>
		</a>



		<a href="[afurl.base]/[user.user_url]">
			[onshow;block=a;when [user.user_id]!=0]
			<img src="[user.img;ifempty='[afurl.static]/thumb2/profile.svg';noerr]"
				class="cpn-profile-pic-[user.user_id]"
				alt="[user.user_name]" title="[user.user_name]" />
			<span>[user.user_name]</span>
		</a>

		<a href="[afurl.base]/settings">
			[onshow;block=a;when [user.user_id]!=0]
			[onshow;svg=static/svg/settings.svg]
			<span>Settings</span>
		</a>




		<a href="[afurl.base]/[af.profile.link;magnet=a]" id="prometheus-profile">
			<img src="[af.profile.image;ifempty=[afurl.static]/thumb2/profile.svg]" alt="[af.profile.name]" />
		</a>



		<a href="[afurl.base]/[sb.link;ifempty=[sb.name;f=lower]]" style="[sb.style;magnet=#]">
			[onshow;svg=static/svg/[sb.svg;ifempty=[sb.link;ifempty=[sb.name;f=lower]]].svg]
			<span>[sb.name;block=a]</span>
		</a>




	</div>
<!--
	<footer id="copyright">
		<a href="[afurl.base]/legal">
			[onshow;svg=static/svg/copyright.svg]
		</a>
	</footer>

	<footer id="prometheus-footer">
		<div>
			<a href="[afurl.base]/legal">&copy; [onshow..now;date=Y] Cospix.net</a>
		</div>
	</footer>
-->
</nav>


<script>
$('#prometheus-sidebar-menu, #prometheus-menu-background').click(function(){
	$('#prometheus-sidebar-links').slideToggle();
	$('#prometheus-menu-background').fadeToggle();
});
</script>
