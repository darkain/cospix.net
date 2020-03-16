<main class="cpn-default cpn-chat">
	<h1 class="cpn-header">[af.title]</h1>
	<div id="messages"></div>
	<form id="chatform" action="">
		<input id="m" autocomplete="off" placeholder="Type Here! :)" />
		<img src="[afurl.static]/img/cpn-right.png" alt="Chat!" onclick="$('#chatform').submit()" />
	</form>
</main>



<script>
var entityMap = {
	"&": "&amp;",
	"<": "&lt;",
	">": "&gt;",
	'"': '&quot;',
	"'": '&#39;',
	"/": '&#x2F;'
};

function escapeHtml(string) {
	return String(string).replace(/[&<>"'\/]/g, function (s) {
		return entityMap[s];
	});
}

$(function(){
	var socket	= io('wss://chat.cospix.net');
	var lastid	= 0;

	$('form').submit(function(){
		socket.emit('chat message', $('#m').val());
		$('#m').val('').focus();
		return false;
	});

	socket.on('connect', function(){
		socket.emit('last id', lastid);
	});

	socket.on('reconnect', function(){
		socket.emit('last id', lastid);
	});

	socket.on('user-[user.user_id]', function(message){
		console.log(message);
	});

	socket.on('chat message', function(message) {
		console.log(message);

		//UPDATE OUR LAST ID
		lastid = message.chat_text_id;

		//APPEND MESSAGE TO THE LIST
		$('#messages').append($('<div>').html(
			'<b>' + message.user_name + '</b> ' + escapeHtml(message.chat_text)
		));

		//SCROLL TO NEW MESSAGE
		$('html, body').stop(true);
		$('html, body').animate({ scrollTop: $(document).height() }, 'slow');
	});
});
</script>
