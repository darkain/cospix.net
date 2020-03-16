<div style="margin-left:-13px;margin-top:-10px">

	<div class="profile-box">
		<div class="profile-box-body" style="padding-right:0">
			<ul class="cpn-map-list cpn-tag-relate">
				<li><a href="[afurl.base]/tag/[tags.group_type_name]/[tags.group_label;f=urlname;block=li;bmagnet=(((div)))]"><figure>
					<img src="[afurl.static]/glyph-cyan/close.png" data-label-id="[tags.group_label_id]" class="cpn-tag-ungroup" [onshow;block=img;when [profile.edit]=1] />
					<img src="[tags.img;noerr;ifempty='[afurl.static]/thumb2/[tags.group_type_name;ifempty=blank].svg']" alt="[tags.group_label]" />
					<figcaption>[tags.group_label]</figcaption>
				</figure></a></li>
			</ul>
			<div class="clear"></div>
		</div>
	</div>

</div>


<div class="cpn-discover">
	<figure>
		<a href="[afurl.base]/image/[g.file_hash;f=hex;noerr]?gallery=[g.gallery_id]">
			<img src="[g.img;ifempty='[afurl.static]/thumb2/[g.gallery_type;ifempty=blank].svg']" alt="[g.gallery_name;ifempty='Untitled [g.gallery_type]']" />
		</a>
		<figcaption>
			<img src="[afurl.static]/thumb2/[g.gallery_type;ifempty=blank].svg" class="cpn-discover-icon" alt="[g.gallery_type]" />
			<div class="cpn-discover-text">
				<span>[g.gallery_name;block=figure;ifempty='Untitled [g.gallery_type]']</span>
				<a href="[afurl.base]/[g.user_url;ifempty=[g.user_id;noerr];noerr]">
					[g.user_name;noerr;magnet=a]
				</a>
			</div>
		</figcaption>
	</figure>

	<div class="clear"></div>
</div>
