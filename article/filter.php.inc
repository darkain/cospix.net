<?php

function lawedfilter($element, $attr_list=0) {
	if(is_numeric($attr_list)) return "</$element>"; 

	static $allowed_styles = array(
		'color', 'float', 'clear', 'vertical-align', 'box-sizing',
		'width', 'min-width', 'max-width',
		'height', 'min-height', 'max-height', 'line-height',
		'text-align', 'text-decoration', 'text-indent', 'text-transform',
		'white-space', 'word-spacing', 'text-outline', 'text-shadow', 'box-shadow',
		'overflow', 'overflow-x', 'overflow-y', 'overflow-style',
		'background', 'background-color',
		'list-style', 'list-style-position', 'list-style-type',
		'font', 'font-family', 'font-size', 'font-style', 'font-variant', 'font-weight',
		'padding', 'padding-top', 'padding-right', 'padding-bottom', 'padding-left',
		'margin', 'margin-top', 'margin-right', 'margin-bottom', 'margin-left',
		'border-collapse', 'border-spacing', 'caption-side', 'empty-cells', 'table-layout',
		'border', 'border-radius', 'border-color', 'border-style', 'border-width',
		'border-top', 'border-top-color', 'border-top-style', 'border-top-width',
		'border-right', 'border-right-color', 'border-right-style', 'border-right-width',
		'border-bottom', 'border-bottom-color', 'border-bottom-style', 'border-bottom-width',
		'border-left', 'border-left-color', 'border-left-style', 'border-left-width',
		'outline', 'outline-color', 'outline-style', 'outline-width',
	);

	$style = array();
	if (!empty($attr_list['style'])) {
		$css = explode(';', $attr_list['style']);
		foreach ($css as $v) {
			if (($p = strpos($v, ':')) > 1 && $p < strlen($v)) {
				$name  = trim(substr($v, 0, $p));
				$value = trim(substr($v, $p+1));
				if (!in_array($name, $allowed_styles)) continue;
				$style[] = "$name:$value";
			}
		}
	}

	// Rebuild inline style value
	if(!empty($style)) {
		$attr_list['style'] = implode(';', $style);
	} else{
		unset($attr_list['style']);
	}

	// Build the element attributes string
	$attr = '';
	if (is_array($attr_list)) foreach($attr_list as $k=>$v){
		$attr .= ' ' .  $k . '="' . $v .'"';
	}

	// Return the opening tag with attributes
	static $empty_elements = array(
		'area'=>1, 'br'=>1, 'col'=>1, 'embed'=>1, 'hr'=>1,
		'img'=>1, 'input'=>1, 'isindex'=>1, 'param'=>1
	);

	return "<$element$attr". (isset($empty_elements[$element]) ? ' /' : ''). '>';
}
