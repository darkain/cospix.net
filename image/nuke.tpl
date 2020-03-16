<div class="larger center" id="nuke-confirm">
	ARE YOU SURE YOU WANT TO PERMANENTLY DELETE THIS IMAGE?<br/>
	THERE IS NO CHANCE FOR AN UNDO FOR THIS.<br/>
	THE IMAGE WILL BE REMOVED FROM *ALL* ALBUMS BY *ALL* USERS<br/>
	ALL THUMBNAILS BASED ON THIS IMAGE WILL BE ERASED, INCLUDING:<br/>
	EVENTS / TAGS / PROFILES / PRODUCTS / VENDORS / COUNTLESS OTHERS<br/>
	<input type="hidden" name="hash" value="[image.file_hash;f=hex]" />
	<input type="hidden" name="confirm" value="1" />
</div>
<br/>
<br/>
<div class="center">
	<button onclick="popdown()" style="font-size:2em;padding:1em 2em">CANCEL</button>
	<br /><br />
	<span class="button" onclick="$.post('[afurl.base]/image/nuke',$('#nuke-confirm').afSerialize(),function(data){$('#popup-window').html(data)});">NUKE</span>
</div>
