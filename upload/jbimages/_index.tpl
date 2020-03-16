<style>
html, body {
	background:#fff;
}

#upl {
	font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;
	-text-align:center;
	padding:0 10px 0 5px;
}

h2 {
	color:#666;
	visibility:hidden;
}

.form-inline input {
	display:inline-block;
	*display:inline;
	margin-bottom:0;
	vertical-align:middle;
	*zoom:1;
	cursor:pointer;
}

#upload_target {border:0; margin:0; padding:0; width:0; height:0; display:none;}

.upload_infobar {display:none; font-size:12pt; background:#fff; margin-top:10px; border-radius:5px;}
.upload_infobar img.spinner {margin-right:10px;}
.upload_infobar a {color:#0000cc;}
#upload_additional_info {font-size:10pt; padding-left:26px;}

#the_plugin_name {margin:15px 0 0 0;}
#the_plugin_name, #the_plugin_name a {color:#777; font-size:9px;}
#the_plugin_name a {text-decoration:none;}
#the_plugin_name a:hover {color:#333;}

/* this class makes the upload script output visible */
.upload_target_visible {width:100%!important; height:200px!important; border:1px solid #000!important; display:block!important}
</style>



<script>
document.domain = 'cospix.net';

var jbImagesDialog = {

	timeoutStore: false,

	inProgress: function() {
		$('#upload_infobar').hide();
		$('#upload_additional_info').html('');
		$('#upload_form_container').hide();
		$('#upload_in_progress').show();
		this.timeoutStore = setTimeout(function(){
			$('#upload_additional_info').html('This is taking longer than usual.' + '<br />' + 'An error may have occurred.' + '<br /><a href="#" onClick="jbImagesDialog.showIframe()">' + 'View script\'s output' + '</a>');
		}, 20000);
	},

	showIframe: function() {
		if (!$('#upload_target').hasClass('upload_target_visible')) {
			$('#upload_target').addClass('upload_target_visible');
		}
	},

	uploadFinish: function(result) {
		console.log(result);

		$('#upload_in_progress').hide();
		$('#upload_infobar').show();

		if (result.resultCode == 'failed') {
			clearTimeout(this.timeoutStore);
			$('#upload_infobar').html(result.result);
			$('#upload_form_container').show();
			return;
		}

		$('#upload_infobar').html('Upload Complete');

		this.getWin().tinymce.EditorManager.activeEditor.insertContent(
			'<img src="' + result.filename +'">'
		);

		this.close();
	},

	getWin: function() {
		return (!window.frameElement && window.dialogArguments) || opener || parent || top;
	},

	close: function() {
		var t = this;

		// To avoid domain relaxing issue in Opera
		function close() {
			tinymce.EditorManager.activeEditor.windowManager.close(window);
			tinymce = tinyMCE = t.editor = t.params = t.dom = t.dom.doc = null; // Cleanup
		};

		if (tinymce.isOpera) {
			this.getWin().setTimeout(close, 0);
		} else {
			close();
		}
	}
};
</script>



<form class="form-inline" id="upl" name="upl" action="[afurl.base]/upload/jbimages/insert" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="jbImagesDialog.inProgress();">
	<div id="upload_in_progress" class="upload_infobar">
		<img src="[afurl.static]/tinymce/plugins/jbimages/img/spinner.gif" width="16" height="16" class="spinner">
		Upload in progress&hellip;
		<div id="upload_additional_info"></div>
	</div>

	<div id="upload_infobar" class="upload_infobar"></div>

	<p id="upload_form_container">
		<input id="uploader" name="file" type="file" accept="image/*" class="jbFileBox" onChange="$('#upl').submit(); jbImagesDialog.inProgress();">
	</p>
</form>

<iframe id="upload_target" name="upload_target" src="[afurl.base]/upload/jbimages/blank"></iframe>
