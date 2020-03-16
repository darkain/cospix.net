<style>
#popup-window { padding:0; }

#cpn-room-list {
	height:100%;
	width:200px;
	overflow-y:auto;
	float:left;
}

#cpn-room-list button {
	width:100%;
	margin:10px 0;
	font-size:20px;
}

#cpn-room-list button svg {
	width:22px;
	height:22px;
	vertical-align:text-bottom;
}

#cpn-room-list div svg {
	width:18px;
	height:18px;
	float:right;
}

#cpn-room-list div {
	cursor:pointer;
	padding:5px;
}

#cpn-room-list div.cpn-room-selected {
	background:#00C8E6;
	color:#fff;
}

#cpn-room-list div:hover svg path,
#cpn-room-list div.cpn-room-selected svg path {
	fill:#fff;
}

#cpn-room-list div:hover,
#cpn-room-list div.cpn-room-selected:hover {
	background:#C800E6;
	color:#fff;
}

#cpn-room-list div svg:hover {
	background:red;
}

#cpn-room-body {
	background:#fcfcfc;
	height:100%;
	margin-left:200px;
	padding:20px;
}

#cpn-room-body b {
	display:block;
	padding-top:20px;
}

#cpn-room-body b:first-child {
	padding-top:0;
}

#cpn-room-body input,
#cpn-room-body select {
	display:block;
	width:100%;
	padding:5px;
}

#cpn-room-body textarea {
	display:block;
	width:100%;
	height:15em;
	padding:5px 8px;
}
</style>

<script>
$(function(){
	$('#cpn-room-list div').click(function(){
		var top = $('#cpn-room-list').scrollTop();
		$('#popup-window').load(
			'[afurl.base]/event/[event.event_name;f=urlname]/schedule/rooms',
			{ id: $(this).data('id') },
			function() {
				$('#cpn-room-list').scrollTop(top);
			}
		);
	});

	$('#cpn-room-list button').click(function(){
		$('#popup-window').load(
			'[afurl.base]/event/[event.event_name;f=urlname]/schedule/rooms'
		);
	});

	$('#cpn-room-list svg').click(function(e){
		e.stopPropagation();
		e.preventDefault();
		$('.cpn-room-selected').removeClass('cpn-room-selected');
		$('#cpn-room-body').load(
			'[afurl.base]/event/[event.event_name;f=urlname]/schedule/roomdelete',
			{ id: $(this).closest('div').addClass('cpn-room-selected').data('id') }
		);
	});

	$('#cpn-room-body').children('input, select, textarea').change(function(){
		var top = $('#cpn-room-list').scrollTop();
		$.post(
			'[afurl.base]/event/[event.event_name;f=urlname]/schedule/roomsave',
			$('#cpn-room-body').afSerialize(),
			function(data){
				var focus = $(':focus').attr('id');
				popupdate(data);
				$('#cpn-room-list').scrollTop(top);
				$('#'+focus).focus();
				console.log('#'+focus);
			}
		);
	});

	popbuttons({'Close': refresh});
});
</script>

<div id="cpn-room-list">
	<button class="cpn-button">
		<svg viewBox="0 0 129 129"><path d="M64.5,6.5c-32,0-58.1,26-58.1,58s26,58,58.1,58c32,0,58-26,58-58S96.5,6.5,64.5,6.5zM64.5,114.4C37,114.4,14.6,92,14.6,64.5S37,14.6,64.5,14.6c27.5,0,49.9,22.4,49.9,49.9S92,114.4,64.5,114.4z"/><path d="M91.2,59.9h-22.6v-22.7c0-2.3-1.8-4.1-4.1-4.1-2.3,0-4.1,1.8-4.1,4.1v22.6h-22.6c-2.3,0-4.1,1.8-4.1,4.1s1.8,4.1 4.1,4.1h22.6v22.6c0,2.3 1.8,4.1 4.1,4.1 2.3,0 4.1-1.8 4.1-4.1v-22.6h22.6c2.3,0 4.1-1.8 4.1-4.1s-1.8-4-4.1-4z"/></svg>
		New Room
	</button>
	<div data-id="[rooms.schedule_room_id]">
		[onshow;att=class;attadd;if [rooms.schedule_room_id]=[room.schedule_room_id];then 'cpn-room-selected']
		[rooms.schedule_room_name;block=div;ifempty='&nbsp;']
		<svg viewBox="0 0 129 129"><path d="m64.5,122.4c31.9,0 57.9-26 57.9-57.9s-26-57.9-57.9-57.9-57.9,26-57.9,57.9 26,57.9 57.9,57.9zm0-107.7c27.4-3.55271e-15 49.8,22.3 49.8,49.8s-22.3,49.8-49.8,49.8-49.8-22.4-49.8-49.8 22.4-49.8 49.8-49.8z"/><path d="M37.8,68h53.3c2.3,0,4.1-1.8,4.1-4.1s-1.8-4.1-4.1-4.1H37.8c-2.3,0-4.1,1.8-4.1,4.1S35.6,68,37.8,68z"/></svg>
	</div>
</div>

<div id="cpn-room-body">
	<b>Name</b>
	<input type="text" name="name" id="room-name"
		value="[room.schedule_room_name]" placeholder="New Room"/>

	<b>Time Increment</b>
	<select name="increment" id="room-increment">
		<option value="15" [room.schedule_room_increment;selected=15]>15 Minutes</option>
		<option value="30" [room.schedule_room_increment;selected=30]>30 Minutes</option>
		<option value="60" [room.schedule_room_increment;selected=60]>60 Minutes</option>
	</select>

	<b>Description</b>
	<textarea name="text" id="room-text" placeholder="Enter additional information for the room here. This text will apear on all panels in this room. Good information to have here is the venue's name for the room: eg 'Ballroom A'">[room.schedule_room_text;safe=textarea]</textarea>

	<input type="hidden" name="id" value="[room.schedule_room_id]"/>
</div>
