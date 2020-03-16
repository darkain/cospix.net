<div data-gallery-id="[gallery.gallery_id]" class="cpn-gallery">

	<span class="gallery-pic">
		<span class="gallery-pic-upload">
			[onshow;block=span;when [user.user_id]=[gallery.user_id]]
			Upload Gallery Image
		</span>
		<input id="file-gallery" type="file" name="file" accept="image/*" data-url="[afurl.base]/gallery/set/icon/[gallery.gallery_id]"  />
		<img src="[gallery.img;ifempty='[afurl.static]/thumb2/gallery.svg']" class="cpn-gallery-image" alt="[gallery.gallery_name] Thumbnail" />
	</span>


	<div class="cpn-gallery-title cpn-header">
		<aside class="cpn-gallery-share cpn-more">
			<div class="cpn-more-content">
				<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=[afurl.all;f=url]">Share on Facebook</a>
				<a target="_blank" href="https://twitter.com/home?status=Check+out+[gallery.gallery_name;ifempty='Untitled Gallery';f=url]+by+[user.user_name;f=url]+on+@CospixNet+[afurl.all;f=url]">Share on Twitter</a>
				<a target="_blank" href="https://plus.google.com/share?url=[afurl.all;f=url]">Share on Google+</a>
				<a target="_blank" href="http://pinterest.com/pin/create/button?url=[afurl.all;f=url]&amp;media=[gallery.img;f=url]">Share on Pinterest</a>
				<a target="_blank" href="http://www.tumblr.com/share/photo?source=[gallery.img;f=url]&amp;click_thru=[afurl.all;f=url]">Share on Tumblr</a>
			</div>
		</aside>

		<div class="cpn-more">
			[onshow;block=div;when [user.user_id]=[gallery.user_id]]
			<div class="cpn-more-content">
				<div id="cpn-delete-gallery">Delete Gallery</div>
			</div>
		</div>

		<h3 itemprop="name">[gallery.gallery_name;ifempty='Untitled Gallery']</h3>
	</div>


	<div class="cpn-gallery-info">
		<table>



			<tr class="cpn-gallery-tag">
				<th>Convention</th>
				<td>
					[onshow;block=tr;when [user.user_id]=[gallery.user_id]]
					<a href="[afurl.base]/event/[gallery.event_name;f=urlname;magnet=a]"></a>
					<div class="cpn-gallery-event">[gallery.event_name]</div>
				</td>
			</tr>
			<tr>
				<th>Convention</th>
				<td>
					[onshow;block=tr;when [user.user_id]!=[gallery.user_id]]
					<a href="[afurl.base]/event/[gallery.event_name;f=urlname;magnet=tr]">[gallery.event_name]</a>
				</td>
			</tr>



			<tr class="cpn-gallery-tag">
				<th>Role</th>
				<td>
					<div>
						[onshow;block=div;when [user.user_id]!=[gallery.user_id]]
						[gallery.role;f=ucfirst]
					</div>
					<select class="cpn-gallery-role-list">
						[onshow;block=select;when [user.user_id]=[gallery.user_id]]
						<option [gallery.gallery_role;att=selected;atttrue=''] value=""></option>
						<option [gallery.gallery_role;att=selected;atttrue='photo'] value="photo">Photographer</option>
						<option [gallery.gallery_role;att=selected;atttrue='cosplay'] value="cosplay">Cosplayer</option>
						<option [gallery.gallery_role;att=selected;atttrue='seamstress'] value="seamstress">Seamstress</option>
						<option [gallery.gallery_role;att=selected;atttrue='wig'] value="wig">Wig/Hair Stylist</option>
						<option [gallery.gallery_role;att=selected;atttrue='mua'] value="mua">Makeup Artist</option>
						<option [gallery.gallery_role;att=selected;atttrue='prop'] value="prop">Prop Maker</option>
						<option [gallery.gallery_role;att=selected;atttrue='accessory'] value="accessory">Accessories</option>
						<option [gallery.gallery_role;att=selected;atttrue='post'] value="post">Post Production</option>
						<option [gallery.gallery_role;att=selected;atttrue='assistant'] value="assistant">Assistant</option>
					</select>
				</td>
			</tr>




			<tr>
				<th>Series</th>
				<td>
					<div id="tags-series">
						<a href="[afurl.base]/tag/series/[series.group_label;f=url,lower]">
							[series.group_label;block=a]
						</a>
					</div>
				</td>
			</tr>



			<tr>
				<th>Characters</th>
				<td>
					<div id="tags-characters">
						<a href="[afurl.base]/tag/character/[character.group_label;f=url,lower]">
							[character.group_label;block=a]
						</a>
					</div>
				</td>
			</tr>


			<tr>
				<th>Details</th>
				<td>
					[onshow;block=td;when [user.user_id]!=[gallery.user_id]]
					<div class="cpn-gallery-notes">
						<p>[gallery.text;safe=no]</p>
					</div>
				</td>
				<td>
					[onshow;block=td;when [user.user_id]=[gallery.user_id]]
					[onload;file=gallery/details.tpl]
				</td>
			</tr>

		</table>

	</div>

	<div class="clear"></div>

</div>
