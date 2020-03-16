<div class="wrapper" style="padding-bottom:10px">
	<div class="cpn-lfs" data-id="[lfs.lfs_id]" data-sort="[lfs.lfs_timestamp;block=div]">

		<a href="[afurl.base]/[lfs.user_url;ifempty='[lfs.user_id]']"><img src="[lfs.thumb_hash;f=cdn]" style="float:left;padding-right:10px" alt="[lfs.user_name]" /></a>

		<div class="lfs-username">
			<a href="[afurl.base]/[lfs.user_url;ifempty='[lfs.user_id]']">[lfs.user_name]</a>
			<span class="lfs-timestamp">posted [lfs.lfs_timestamp;ope=add:-18000;date=r]</span>
			<button class="lfs-republish cpn-button">Republish[onshow;block=button;when [user.user_id]=[lfs.user_id]]</button>
		</div>
		<div class="lfs-lookingfor">[lfs.lfs_iam;f=ucfirst] looking for [lfs.lfs_lookingfor;f=ucfirst]<span> at [lfs.location_name;magnet=span]</span></div>
		<div style="font-size:24px; padding-left:110px">[lfs.lfs_message]</div>
		<div class="clear"></div>
	</div>
</div>
