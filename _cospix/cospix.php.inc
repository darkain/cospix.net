<?php

require_once('filter.php.inc');
require_once('tag.php.inc');

require_once('cpn_photo.php.inc');
require_once('cpn_event.php.inc');
require_once('cpn_user.php.inc');
require_once('cpn_tag.php.inc');
require_once('cpn_gallery.php.inc');
require_once('cpn_custom.php.inc');




////////////////////////////////////////////////////////////////////////////////
// FORCE DESKTOP DISPLAY
// NOTE: THIS IS DEPRECATED
//       ALL DISPLAY SPECIFIC CONFIGS ARE SET TO BE REMOVED
////////////////////////////////////////////////////////////////////////////////
\af\device::set('desktop');




////////////////////////////////////////////////////////////////////////////////
// DISPLAY WHICH HOSTNAME IS PROCESSING THIS REQUEST
////////////////////////////////////////////////////////////////////////////////
if (!headers_sent()) {
	header('x-hostname: ' . gethostname());
}




////////////////////////////////////////////////////////////////////////////////
// BASE CLIENT CONFIG
////////////////////////////////////////////////////////////////////////////////
$og = [
	'title'			=> 'Cospix',
	'image' 		=> '',
	'description'	=> '',
	'keywords'		=> '',
	'viewport'		=> 'width=device-width,initial-scale=1',
	'themecolor'	=> '#00C8E6',
	'themeicon'		=> '/static/img/cpn-logo-icon.png',
	'twittername'	=> '@cospixnet',
	'twitterdomain'	=> 'Cospix.net',
];




////////////////////////////////////////////////////////////////////////////////
// THIS SHOULD REALLY BE A TABLE, NOT STATIC IN CODE
////////////////////////////////////////////////////////////////////////////////
function cpn_role($role) {
	switch ($role) {
		case 'photo':		return 'Photographer';
		case 'cosplay':		return 'Cosplayer';
		case 'seamstress':	return 'Seamstress';
		case 'wig':			return 'Wig/Hair Stylist';
		case 'mua':			return 'Makeup Artist';
		case 'prop':		return 'Prop Maker';
		case 'accessory':	return 'Accessories';
		case 'post':		return 'Post Production';
		case 'assistant':	return 'Assistant';
	}
	return '';
}




////////////////////////////////////////////////////////////////////////////////
// SET OUR ALTAFORM CLASS OVERRIDE
////////////////////////////////////////////////////////////////////////////////
altaform::$class = 'cospix_altaform';




////////////////////////////////////////////////////////////////////////////////
// OUR ALTAFORM CLASS!
////////////////////////////////////////////////////////////////////////////////
class cospix_altaform extends altaform {


	public function __construct($dbsession=false) {
		global $afurl;

		parent::__construct($dbsession);

		$this->headers('notice', []);

		$this->prometheus = [
			['name' => 'Discover'],
			['name' => 'Profiles',		'link'	=> 'profile',],
//			['name' => 'Featured',		'link'	=> 'featured/'.date('Y-m'),	'svg'=>'featured'],
			['name' => 'Galleries',		'link'	=> 'gallery'],
//			['name' => 'Calendar'],
//			['name' => 'Event Map',		'link'	=> 'map'],
//			['name' => 'Marketplace'],
			['name' => 'Browse Tags',	'link'	=> 'tag'],
		];


		$this->profile = [
			'link'	=> '',
			'image'	=> 'thumb2/profile.svg',
		];


		$this->pudl->on('warning', function($type, $db, $value, $clause){
			global $af;
			$x = \af\debug::log(['a-value'=>$value, 'a-clause'=>$clause], $af->debug());
		});
	}




	public function header($key=false, $data=false, $replace=false) {
		$this->headers('sb', $this->prometheus);
		return parent::header($key, $data, $replace);
	}




	public function postLogin() {
		global $user, $db, $router;

		parent::postLogin();

		$router->homepage = 'story';

		if (!$user->loggedIn()) {
			$user->messages			= 0;
			return;
		}


		if ($user->isStafF()) {
			array_push($this->prometheus, ['name'=>'Admin', 'style'=> 'color:#f00']);
		}


		$user->img					= $user->image();
		$user->user_class			= 'logged-in';

		$user->messages				= $db->count('pudl_notification', [
			'notification_user_to'	=> $user['user_id'],
			'notification_read'		=> 0,
		]);
	}




	protected function _customFormat(&$text, $style) {
		switch ($style) {
			case 'urldate':
				$text = strtolower(date('Y/M', $text));
			break;

			default:
				parent::_customFormat($text, $style);
		}
	}



	public static function prometheus() { return true; }



	public function discoverWidth($item, $size=300) {

		//PULL FROM DATABASE
		if (!empty($item['file_width'])  &&  !empty($item['file_height'])) {
			$width	= $item['file_width'];
			$height	= $item['file_height'];

		//PULLED FROM EXIF DATA
		} else if (!empty($item['file_meta_value']['COMPUTED']['Width'])
				&& !empty($item['file_meta_value']['COMPUTED']['Height'])) {
			$width	= $item['file_meta_value']['COMPUTED']['Width'];
			$height	= $item['file_meta_value']['COMPUTED']['Height'];

		} else {
			return $size;
		}

		//TODO: SEE IF WE NEED ORIENTATION WITH GETIMAGESIZE()
		$orientation = 0;
		if (!empty($item['file_meta_value']['Orientation'])) {
			$orientation = (int) $item['file_meta_value']['Orientation'];
		}

		$ratio = ($orientation>4) ? ($height/$width) : ($width/$height);

		return (int) ($size * min(max($ratio, 0.5), 1.4));
	}




	public function scale($scale) {
		$this->scale = $scale ? 'prometheus-scale' : 'prometheus-no-scale';
	}




	public $prometheus	= [];
	public $profile		= [];
	public $scale		= 'prometheus-scale';
}
