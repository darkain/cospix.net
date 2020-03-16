<style>

#market-header {
	background:url(https://cospix.net/files/d3d/8b7/d3d8b70a1e0c4260b539ef4a738f249f.jpg);
	background-size:120%;
	background-position:50% 0px;
	width:100%;
	height:0;
	padding-bottom:25%;
	position:relative;
}

#market-header>div {
	position:absolute;
	bottom:0;
	font-size:5vw;
	padding:0.15em 0.3em;
	color:#fff;
	text-shadow:0 0 0.05em #000, 0 0 0.1em #000, 0 0 0.2em #000;
}

.prometheus-tabs table.cpn-folder td {
	font-size:3vw !important;
	padding:0 !important;
}


#market {
	margin-top:3em;
	display:flex;
	flex-wrap:wrap;
	margin-left:-1em;
}

#market a {
	width:300px;
	max-height:400px;
	flex:1 1 auto;
	max-width:100%;
	background:rgba(255,255,255,0.2);
	overflow:hidden;
	position:relative;
	margin:0 0 1em 1em;
	display:block;
}

#market figure {
	width:100%;
	height:100%;
}

#market a:before {
	content:"";
	display:block;
	padding-top:70%;
}

#market figure img {
	width:100%;
	position:absolute;
	top:0;
	left:0;
	bottom:0;
	right:0;
	z-index:1;
	min-height:100%;
}

#market figure figcaption {
	width:100%;
	position:absolute;
	top:0;
	left:0;
	right:0;
	z-index:2;
	background:rgba(255,255,255,0.8);
	padding:0.3em 0.5em;
	font-size:1.3em;
	display:flex;
	text-shadow:0 0 1px #fff, 0 0 2px #fff, 0 0 5px #fff;
}

#market figure figcaption>* {
	display:block;
}

#market figure figcaption div {
	flex-grow:1;
	flex-shrink:1;
	text-overflow:ellipsis;
	white-space:nowrap;
	overflow:hidden;
	color:#345;
}

#market figure figcaption span {
	flex:0 0;
	color:#B24D0A;
	text-align:right;
}
</style>

<div id="market-header">
	<div>Marketplace</div>
</div>


<div class="prometheus-tabs">
	<table class="cpn-folder">
		<tr>
			<td class="cpn-folder-selected">Buying</td>
			<td>Selling</td>
			<td>Commissioning</td>
		</tr>
	</table>
</main>


<div id="market">
	<a target="_blank" href="https://www.etsy.com/listing/524007797/final-fantasy-moogle-bloomerumi">
		<figure>
			<figcaption>
				<div>Final Fantasy - Moogle Bloomerumi</div>
				<span>$180</span>
			</figcaption>
			<img src="[afurl.static]/bloomer/1.jpg"/>
		</figure>
	</a>

	<a target="_blank" href="https://www.etsy.com/listing/505930817/sailor-moon-cats-bloomerumi">
		<figure>
			<figcaption>
				<div>Sailor Moon - Cats Bloomerumi</div>
				<span>$160</span>
			</figcaption>
			<img src="[afurl.static]/bloomer/2.jpg"/>
		</figure>
	</a>

	<a target="_blank" href="https://www.etsy.com/listing/247476664/gloomerumi-gloomy-bear-bloomerumi">
		<figure>
			<figcaption>
				<div>Gloomerumi - Gloomy Bear Bloomerumi</div>
				<span>$215</span>
			</figcaption>
			<img src="[afurl.static]/bloomer/3.jpg"/>
		</figure>
	</a>
</div>
