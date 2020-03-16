<section style="margin-left:-13px">


	<div class="profile-box">
		<h3 class="cpn-header">[af.title]</h3>
		<div class="profile-box-body" style="padding-right:0">
			<ul class="cpn-map-list cpn-tag-relate">
				<li itemprop="character" itemscope itemtype="http://schema.org/Person">
					<a href="[afurl.base]/tag/[character.group_type_name]/[character.group_label;f=urlname;block=li;bmagnet=((div))]" itemprop="url">
						<figure>
							<img src="[afurl.static]/glyph-cyan/close.png" data-label-id="[character.group_id]" class="cpn-tag-unlink" [onshow;block=img;when [profile.edit]=1] />
							<img src="[character.img;noerr;ifempty='[afurl.static]/thumb2/character.svg']" alt="[character.group_label]" itemprop="image" />
							<figcaption itemprop="name">[character.group_label]</figcaption>
						</figure>
					</a>
				</li>
			</ul>
			<div class="clear"></div>
		</div>
	</div>


	<div class="profile-box">
		<h3 class="cpn-header">[af.title]</h3>
		<div class="profile-box-body" style="padding:2px">
			<ul class="cpn-tag-boxes">
				<li itemprop="character" itemscope itemtype="http://schema.org/Person">
					<a href="[afurl.base]/tag/[character2.group_type_name]/[character2.group_label;f=urlname;block=li;bmagnet=((div))]" class="cpn-thumb-link" itemprop="url"><figure>
						<img src="[character2.img;noerr;ifempty='[afurl.static]/thumb2/character.svg']" itemprop="image" />
						<figcaption itemprop="name">[character2.group_label]</figcaption>
					</figure></a>
				</li>
			</ul>
			<div class="clear"></div>
		</div>
	</div>


	<div class="profile-box">
		<h3 class="cpn-header">Recommended Characters</h3>
		<div class="profile-box-body" style="padding-right:0">
			<ul class="cpn-map-list">
				<li style="float:left;width:263px;margin-right:5px"><a href="[afurl.base]/tag/[recommend.group_type_name]/[recommend.group_label;f=urlname;block=li;bmagnet=((div))]">
					<img src="[afurl.static]/glyph-cyan/add.png" data-label-id="[recommend.group_id]" class="cpn-tag-link" [onshow;block=img;when [profile.edit]=1] />
					<img src="[recommend.img;noerr;ifempty='[afurl.static]/thumb2/character.svg']" alt="[recommend.group_label]" />
					<strong>[recommend.group_label]</strong>
				</a></li>
			</ul>
			<div class="clear"></div>
		</div>
	</div>


</section>


[onload;file=edit.tpl]
