html #body {
	position: absolute;
	width: 100%;
	height:500%;
	margin:0 !important;
	bottom: 0;
	overflow: hidden;
	transform-origin: 50% 100%;
	transform: perspective(300px) rotateX(20deg);
	z-index:1;
	font-size:5vw;
	z-index:99;
}

html #body a {
	font-size:3vw;
}

html #body ol {
	padding-left:1.5em;
}

html #body h1 {
	font-size:1em;
}

html.notranslate, html body, html body *, html #body, #body * {
	color:#ff0 !important;
	background:#000 !important
}

footer {
	display:none !important;
}

#body:after {
	position: absolute;
	content: ' ';
	left: 0;
	right: 0;
	top: 0;
	bottom: 60%;
	background-image:linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 100%) !important;
	pointer-events: none;
	z-index:9999;
}

#body article {
	position: absolute;
	top: 110%;
	animation: scroll 100s linear infinite;
}

@keyframes scroll {
	0% { top: 100%; }
	100% { top: -250%; }
}
