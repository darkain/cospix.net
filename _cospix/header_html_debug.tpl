<!DOCTYPE html>
<html lang="en" class="notranslate">
<head><meta charset="UTF-8" />

<!-- THIS IS ONLY DEFINED ON THE DEV SITE - PREVENTS SPIDERS/INDEXING -->
<meta name="robots" content="noindex, nofollow" />

<title>[af.title;magnet=title;safe=nobr] - [og.title]</title>
<title>[onshow;block=title;when '[af.title;safe=nobr;noerr]'=''][og.title]</title>

<meta name="generator" content="AltaForm" />
<meta name="rating" content="general" />
<meta name="google" content="notranslate" />
<meta name="description" content="[og.description;magnet=meta;safe=nobr]" />
<meta name="keywords" content="[og.keywords;magnet=meta]" />
<meta name="viewport" content="[og.viewport;magnet=meta]" />
<meta name="theme-color" content="[og.themecolor;magnet=meta]" />

<meta property="fb:app_id" content="[af.config.facebook.id;magnet=meta]" />
<meta property="og:type" content="website" />
<meta property="og:url" content="[afurl.all]" />
<meta property="og:site_name" content="[og.title;noerr]" />
<meta property="og:title" content="[af.title;safe=nobr;magnet=meta] - [og.title]" />
<meta property="og:title" content="[onshow;block=meta;when '[af.title;safe=nobr;noerr]'=''][og.title]" />
<meta property="og:image" content="[og.image;ifempty='[afurl.static]/img/cospix-facebook.png']" />
<meta property="og:description" content="[og.description;magnet=meta;safe=nobr]" />

<meta name="[meta.name;magnet=#]" property="[meta.property;magnet=#]" content="[meta.content;block=meta;safe=nobr]" />

<script>
var urlbase			= '[afurl.base]';
var ga_account		= '[af.config.google.analytics;noerr]';
var ga_domain		= '[af.config.google.domain;noerr]';
var ga_userid		= '[user.user_id;ifempty=0]';
window.onerror		= function(message,file,line,col,error) {
	var details		= {
		url:		document.location.href,
		message:	message,
		file:		file,
		line:		line,
		col:		col,
		error:		error,
		trace:		error?error.stack:null
	};
	console.log(details);
	$.post(urlbase+'/status/error', details);
};
</script>

<link rel="canonical" href="[og.canonical;ifempty='[afurl.protocol]://[afurl.domain][afurl.base][afurl.url]']" />

<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/fonts/trebuchet.css" />

<link rel="stylesheet" type="text/css" href="[style.path;block=link]" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/altaform/af.scss" />

<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cospix.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-article.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-badge.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-button.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-checklist.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-comment.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-costume.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-credit.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-discover.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-discussion.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-droplist.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-feature.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-feed.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-folder.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-gallery.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-home.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-image.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-loading.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-login.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-map.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-message.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-page.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-popup-gallery.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-popup.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-profile.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-schedule.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-settings.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-svg.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-tag.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-tools.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-upload.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-vendor.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-vote.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/cpn-youtube.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/featherlight.min.css" />
<link rel="stylesheet" type="text/css" href="[afurl.static]/css/prometheus.css" />

<link rel="stylesheet" type="text/css" href="[afurl.static]/tagit/css/jquery.tagit.css" />

<link rel="icon" sizes="192x192" href="[og.themeicon;noerr;magnet=link]" />
<link rel="shortcut icon" href="[afurl.static]/img/cpn-logo-icon.png" />
<link rel="apple-touch-icon" href="[afurl.static]/img/cpn-logo-200.png" />
<link rel="sitemap" type="application/xml" title="Sitemap" href="[og.sitemap;magnet=link]" />

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="[afurl.static]/jquery/jquery-3.3.1.min.js"><\/script>')</script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script>window.jQuery.ui || document.write('<script src="[afurl.static]/jquery/jquery-ui.min.js"><\/script>')</script>

<script src="[afurl.static]/jquery/jquery-ui.punch.js?1"></script>
<script src="[afurl.static]/jquery/jquery-ui.mousehax.js"></script>

<script src="[afurl.static]/tagit/js/tag-it.js"></script>

<script src="[afurl.static]/js/socketio.js"></script>
<script src="[afurl.static]/js/jquery.bindWithDelay.js"></script>
<script src="[afurl.static]/js/jquery.history.js"></script>
<script src="[afurl.static]/js/jquery.fileupload.js"></script>
<script src="[afurl.static]/js/jquery.readmore.js"></script>
<script src="[afurl.static]/js/jquery.iframe-transport.js"></script>
<script src="[afurl.static]/js/jquery.tinyscroll.min.js"></script>
<script src="[afurl.static]/js/dropzone.js"></script>
<script src="[afurl.static]/js/featherlight.min.js"></script>
<script src="[afurl.static]/js/prometheus.js"></script>

<script src="[afurl.static]/altaform/af.js"></script>
<script src="[afurl.static]/altaform/af-date.js"></script>
<script src="[afurl.static]/altaform/af-droplist.js"></script>
<script src="[afurl.static]/altaform/af-dropzone.js"></script>
<script src="[afurl.static]/altaform/af-google.js"></script>
<script src="[afurl.static]/altaform/af-history.js"></script>
<script src="[afurl.static]/altaform/af-jquery.js"></script>
<script src="[afurl.static]/altaform/af-more.js"></script>
<script src="[afurl.static]/altaform/af-popup.js"></script>
<script src="[afurl.static]/altaform/af-spreadsheet.js"></script>

<script src="[afurl.static]/js/cpn-comment.js"></script>
<script src="[afurl.static]/js/cpn-message.js"></script>
<script src="[afurl.static]/js/cpn-onload.js"></script>

<script src="[script.path;block=script]"></script>

<script>[js;safe=no;magnet=script]</script>
<style>[css;safe=no;magnet=style]</style>
</head>
