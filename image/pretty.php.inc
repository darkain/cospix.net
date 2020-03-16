<?php

function prettyExif(&$exif, $html=true) {
	if (empty($exif)) return;

	if (!empty($exif['FocalLength'])) {
		$pos = strpos($exif['FocalLength'], '/');
		if (!empty($pos)) {
			$num1 = (int)substr($exif['FocalLength'],0,$pos);
			$num2 = (int)substr($exif['FocalLength'],$pos+1);
			if ($num1 > 0  &&  $num2 > 0) {
				$exif['FocalLength'] = $num1 / $num2;
			} else {
				$exif['FocalLength'] = 0;
			}
		}
	}

	if (!empty($exif['DateTimeOriginal'])) {
		$time = @strtotime($exif['DateTimeOriginal']);
		if ($time) {
			$exif['DateTimeOriginal'] = date('l, F jS, Y \a\t g:i:s A', $time);
		}
	}

	foreach ($exif as &$item) {
		if (is_array($item)) {
			prettyExif($item);
		} else if (is_string($item)) {
			$item = str_replace('f/', 'ƒ/', $item);
			$item = htmlspecialchars($item);

			if ($html) {
				$href	= '|(https?://([\d\w\.-]+\.[\w\.]{2,6})[^\s\]\[\<\>]*/?)|i';
				$url	= '<a href="$1" target="_blank">$2</a>';
				$item	= preg_replace($href, $url, $item);
			}
		}
	}
}
