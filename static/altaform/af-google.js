$(function() {
	setTimeout(function(){
		//Goolge Adsense
		if ($('.adsbygoogle').length) {
			try{(adsbygoogle=window.adsbygoogle||[]).push({});}catch(err){console.log(err);}
		}
		//Google Analytics
		if (typeof(ga_account) != 'undefined'  &&  ga_account.length) {
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', ga_account, ga_domain);
			if (typeof(ga_userid) != 'undefined'  &&  ga_userid>0) ga('set', '&uid', ga_userid);
			ga('send', 'pageview');
		}
	}, 100);
});
