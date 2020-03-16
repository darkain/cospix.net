<a href="[message.url]"
	data-id="[message.notification_id;block=a]"
	data-from="[message.notification_user_from]"
	data-time="[message.notification_timestamp]"
	onclick="cpn_message_click(event, this)">

	[message.class;att=class;attadd]

	<span class="cpn-message-action" data-click="[message.action;noerr]" onclick="cpn_message_action(event, this)">
		[message.action_text;noerr;magnet=span]
	</span>

	<img src="[message.img;ifempty='[afurl.static]/thumb2/profile.svg']"
		alt="[message.user_name]" style="vertical-align:top" />

	<b>[message.user_name]</b>
	[message.text]
	<b>[message.object_name;noerr;magnet=b]</b>
	<span> "[message.notification_text;magnet=span]"</span>

	<i>[message.timesince]</i>

	<span class="clear">&nbsp;</span>
</a>
