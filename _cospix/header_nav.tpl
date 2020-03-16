<div id="cospix-message-list"></div>


<nav id="prometheus-sidebar">
	<a href="[afurl.base]/" id="cospix-logo">
		[onshow;svg=static/svg/cospix.svg]
	</a>

	<a href="[afurl.base]/" id="cospix-mobile-logo">
		[onshow;svg=static/svg/app-icon.svg]
	</a>

	[onload;file=header_profile.tpl]

	<div id="prometheus-sidebar-links">
		<a href="[afurl.base]/[af.profile.link;magnet=a]" id="prometheus-profile">
			<img src="[af.profile.image;ifempty=[afurl.static]/thumb2/profile.svg]" alt="[af.profile.name]" />
		</a>

		<a href="[afurl.base]/[sb.link;ifempty=[sb.name;f=lower]]" style="[sb.style;magnet=#]">
			[onshow;svg=static/svg/[sb.svg;ifempty=[sb.link;ifempty=[sb.name;f=lower]]].svg]
			<span>[sb.name;block=a]</span>
		</a>
	</div>

	<footer id="copyright">
		<a href="[afurl.base]/legal">
			[onshow;svg=static/svg/copyright.svg]
		</a>
	</footer>

	<footer id="prometheus-footer">
		<div class="smaller" style="padding-top:0.5em">
			<a href="[afurl.base]/legal/tos">Terms</a> ·
			<a href="[afurl.base]/legal/privacy">Privacy</a> ·
			<a href="[afurl.base]/legal/copyright">Copyright</a>
		</div>
		<div class="smaller">
			<a href="[afurl.base]/staff">Contact</a> ·
			<a href="[afurl.base]/branding">Branding</a> ·
			<a href="[afurl.base]/bugs">Bugs</a>
		</div>
		<div class="smaller" style="padding-top:0.5em">
			<a href="[afurl.base]/legal">&copy; [onshow..now;date=Y] Cospix LLC</a>
		</div>
	</footer>
</nav>

