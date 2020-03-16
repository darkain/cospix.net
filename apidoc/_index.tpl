<title>API Documentation</title>

<style>
.api-example {
	table-layout:fixed;
	width:100%;
}

.api-example td {
	overflow:auto;
	border:1px dashed #aaa;
	margin:0;
	font-size:15px;
	white-space:pre;
	vertical-align:top;
}

section{text-align:justify; display:none;}
article.cpn-default{margin:20px auto;}
h1.cpn-header {cursor:pointer}
</style>

<div class="center">Last Updated: 2014-07-17</div>

<article class="cpn-default">
	<h1 class="cpn-header">API Documentation Overview</h1>
	<section class="cpn-default largest">
		This is a brief description of the Cospix.net web products
		and services support system.
		<br/><br/><br/>

		"<b>PRODUCTS</b>"" are defined as physical products that can
		be purchased and shipped to end users. Examples include full
		outfits, wigs, props, jewelry, accessories, etc. Users on
		the Cospix.net web site can associate any product in the site's
		database to any number of their costumes. Once associated, the
		product appears on their costume details page. Additionally,
		the product may appear on any image page that is associated
		with this costume, even if not directly linked from their
		own profile
		<br/><br/>
		<i>example: a cosplayer associates a wig to their "Sailor
		Moon" cosplay, photographer takes a photo of that cosplay and
		posts the photo, the photo is credited back to the cosplayer and
		their outfit, so on the photographer's photo, it can also
		potentially display the product.</i>
		<br/><br/><br/>

		"<b>SERVICES</b>" are defined as non-physical actions. Some
		examples of these can include access to streaming media
		content, download content, or other virtual property goods.
		The service provider can associate their respective services to
		their respective related tags within the Cospix.net web site.
		Much like with products, this enables the possibility of available
		services to appear on photos, galleries, costumes, and more.
		<br/><br/>
		<i>example: the streaming service for "Sailor Moon Crystal" is
		associated with the series tag of the same name in the Cospix.net
		database. A cosplayer lists their outfit with this series. Now
		any photo linked to this outfit can potentially display a
		reference back to the Sailor Moon Crystal streaming service on
		the provider's own web site.</i>
		<br/><br/><br/>

		<b>NOTE</b> that commissions do not fall under either of these
		two categories, and will be handled separately later with a
		dedicated commissions system.
		<br/><br/><br/>

		<b>NOTE</b> that in both examples above, the association only
		happens once. In the products example, the coslayer only links
		the product once to their cosplay details. All images and other
		associated pages inherit the product associations automatically.
		Similarly, services are only associated with tags with the
		Cospix.net database. Services associated with these tags are
		automatically inherited wherever the tag is used, such as on a
		user's costume within the web site. This approach brings
		unprecedented deep linking to products and services, and
		maintains relevance and historical value over time.
		<br/><br/><br/>

		<b>NOTE</b> that the automated deep linking within the web site
		is not limited to the examples listed above. Another example is
		the ability for a cosplayer on the Cospix.net web site to add
		a new costume to their profile and mark the status as "In
		Progress" - when this costume is tagged as the character "Sailor
		Moon", the web site can exploit this deep linking and give wig
		purchasing suggestions based on the wigs other cosplayers have
		linked to their costumes with the same character tag.
		<br/><br/><br/>

		<b>NOTE</b> that currently over 99% of costumes on the Cospix.net
		web site have either a "Series" and/or "Character" tag, enabling
		these deep linking features on virtually all costume pages on
		the web site.
		<br/><br/><br/>

		This feature of the Cospix.net web site is currently in a trial
		period. This trial period is active now until December 31st, 2014.
		There is currently no fees for entering into this trial period,
		however there will be fees to continue to use this service once we
		enter 2015. Fees will be based on either a per-click-through rate
		for products and services, or on a per-sales-commission rate for
		products when this time comes. The specific rates will be determined
		based on current competitive market values closer to the January 1st
		launch date.
	</section>
</article>



<article class="cpn-default">
	<h1 class="cpn-header">Tagging</h1>
	<section class="cpn-default largest">
		<div class="center">
			<img src="[afurl.static]/resources/cospix-tagging.png" style="padding:20px; background:#00C8E6" />
		</div>
		<br /><br />

		Tags on the Cospix.net web site work similarly to hashtags on other
		various social media sites (such as Twitter or Facebook), but with
		some major difference. Tags on the Cospix.net platform additionally
		are organized into "namespaces" and are also editable after being
		posted on user's content.
		<br /><br />

		In the diagram below, the first namespace given is "Universe" -
		these tags generally refer to a company or grouping of properties
		within a company. This terminology is most common in the comic book
		world with the examples of the "Marvel Universe" or "DC Universe"
		<br /><br />

		With our example, we start with the company "Square Enix" as a
		universe. Under this, we have a collection of "Series" that are
		linked to our universe. In our example, we have a total of FIVE
		tags in the Series namespace.
		<br /><br />

		Sometimes tags are directly interchangeable with one-another, so
		they are grouped together as "Alternate Tags". On the left branch,
		we have three different iterations of "Final Fantasy VII" and on
		the right branch we have two different iterations of "Final
		Fantasy X". These groupings are primarily determined by the third
		namespace: "Character" - they are grouped based on the occurrence
		of characters within a given series. For example: Character "Cloud
		Strife" appears in "Final Fantasy VII" but not in "Final Fantasy X",
		so it wouldn't be appropriate to group VII and X into the same set.
		<br /><br />

		Interchangeable alternative tag names may also be used for regional
		localizations. This can be seen with the example of "Aerith
		Gainsborough" vs "Aeris Gainsborough" - This is only one character,
		but the name is different based on regional translations of the
		series.
		<br /><br />

		Why is this important in the Cospix.net system? When assigning a
		product or a service to a particular "Series" or "Character" tag,
		users may be using an alternative name for that series or
		character. With our system, there is no need for you as a vendor
		to keep track of these alternatives over time as information
		changes. These relational links are handled automatically within
		the Cospix.net system. Additionally, the hierarchical links
		between Universe, Series, and Character are all handled by the
		Cospix.net system, so if you assign as product to a particular
		Character tag, the product will also be available under the
		linked Series and Universe tags automatically.
	</section>
</article>



<article class="cpn-default">
	<h1 class="cpn-header">Data Formats</h1>
	<section class="cpn-default largest">
		The Cospix.net web site has a series of intelligent data file format
		importers. Files can be emailed to:
		<a href="mailto:apidoc@cospix.net">apidoc@cospix.net</a>
		<br/><br/>

		Currently these upload tools are only accessible by select
		Cospix.net development staff. Later in this trial process, these
		upload and management tools will be made available to products and
		services owners. Additionally, an API is in development that will
		allow for server-to-server automated information syndication.
		<br/><br/>

		Supported file formats include: CSV, Tab Delimited, Microsoft Excel
		XLS, Microsoft Excel XLSX, and XML.
		<br/><br/>

		Columns and XML entities may appear in any order. Column header and
		XML entity names may be anything, and are dynamically linked to
		Cospix.net internal data structures upon importing.
		<br/><br/>

		<b>"PRODUCTS"</b> have the following possible columns: unique
		identifier, product title, product description, URL to product's web
		page, URL to product's image, product's price, comma separated list
		of associated Cospix.net tags.
		<br/><br/>

		<b>"SERVICES"</b> have the following possible columns: unique
		identifier, service title, service description, URL to service's web
		page, URL to service's image, comma separated list of associated
		Cospix.net tags.
		<br/><br/>

		Product description and service description may contain a limited
		set of HTML formatting entities. No other fields support HTML.
		<br/><br/>

		For CSV files, comma separated list of associated tags should be
		enclosed within double-quote characters.
		<br/><br/>

		Product and service images will be downloaded, copied, and hosted
		by the Cospix.net's Content Delivery Network. These images will
		also be automatically made into 50x50, 100x100, 150x150, and
		200x200 pixel icons for display on the Cospix.net web site. Larger
		square icons may be produced in the future for high-dpi displays.
		<br/><br/>

		<hr/>
		<b>EXAMPLES</b><br/><br/>

		<b>Products</b>
		<table class="api-example" cellspacing="0">
			<tr>
				<th>Unique ID</th>
				<th>Product</th>
				<th>Description</th>
				<th>Price</th>
				<th>Link</th>
				<th>Image</th>
				<th>Tags</th>
			</tr>
			<tr>
				<td>1128</td>
				<td>PRINCESS SAILOR MOON COSPLAY YELLOW WIG</td>
				<td>*High-Temperature Synthetic Fiber superior to Kanekalon!
*High Volume, High Fibercount design to create a full and luscious feel!
*Stylable with heat based tools such as Curling Irons, Straighteners, and Blowdryers!
*Tangle and Frizzle Free. Can be brushed with any comb!
*Usable with all styling products such as gels, hairsprays, spiking glue or dye</td>
				<td>$56.99</td>
				<td>http://www.epiccosplay.com/princess-sailor-moon-cosplay-yellow-wig.html</td>
				<td>http://www.epiccosplay.com/images/detailed/7/7501Q-1.jpg</td>
				<td>Sailor Moon, Eternal Sailor Moon, Super Sailor Moon, Usagi Tsukino</td>
			</tr>
			<tr>
				<td>1113</td>
				<td>RAINBOW DASH COSPLAY WIG</td>
				<td>Very Thick, Perfect Color gradiant for Rainbow Dash</td>
				<td>$45.99</td>
				<td>http://www.epiccosplay.com/rainbow-dash-cosplay-wig-my-little-pony-friendship-is-magic.html</td>
				<td>http://www.epiccosplay.com/images/detailed/6/RainbowDash_01.jpg</td>
				<td>Rainbow Dash, My Little Pony: Friendship is Magic</td>
			</tr>
		</table>
	</section>
</article>


<script>
$(function(){
	$('h1.cpn-header').click(function(){
		$(this).parent('article').find('section').toggle();
	});
});
</script>
