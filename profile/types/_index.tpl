<style>
.cpn-parent-types {
	background:rgba(255,255,255,0.75);
}

.cpn-parent-types h3 {
	padding:1em;
}

.cpn-parent-types button {
	margin:1em;
	font-size:1.5em;
	padding:0.5em 3em;
}

.cpn-edit-types {
	float:left;
	width:350px;
	font-size:20px;
	margin:2px;
	cursor:pointer;
	padding-left:3px;
}

.cpn-edit-types:hover {
	background-color:#fff;
}

.cpn-edit-types span {
	width:100%;
	height:100%;
	display:block;
	padding:0 0 0 20px;
}

.cpn-edit-types-active {
	background-image:url('[afurl.static]/img/check.png');
	background-size:20px 20px;
	background-repeat:no-repeat;
	background-position:left center;
}
</style>


<div class="cpn-parent-types">
	<h3>Edit Things I Do</h3>

	<div class="cpn-edit-types">
		<span class="cpn-edit-types-active">
			[usertypes.val;block=div][onshow;block=span;when [types.[usertypes.$];noerr]=1]
		</span>
		<span>
			[usertypes.val;block=div][onshow;block=span;when [types.[usertypes.$];noerr]!=1]
		</span>
	</div>

	<div class="clear"></div>

	<button onclick="cpn_save_types()" class="cpn-button">
		Save
	</button>
</div>


<script>
$('.cpn-edit-types span').click(function(){
	$(this).toggleClass('cpn-edit-types-active');
});

var cpn_save_types = function() {
	var str = '';
	$('.cpn-edit-types-active').each(function(idx,itm){
		str += $(itm).text().trim() + ','
	});
	$.post('[afurl.base]/profile/types/save', {types:str}, refresh);

}
</script>
