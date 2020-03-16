<?php



require_once('cpn_orm.php.inc');



class			cpn_tag
	extends		cpn_orm {
	use			cpnt_orm;




	////////////////////////////////////////////////////////////////////////////
	//CONSTRUCTOR
	////////////////////////////////////////////////////////////////////////////
	public function __construct($item=false, $fetch=false) {
		parent::__construct($item, $fetch);
		$this->class = 'cpn-discover-tag';
	}




	////////////////////////////////////////////////////////////////////////////
	//URL TO THIS OBJECT
	////////////////////////////////////////////////////////////////////////////
	public function url() {
		global $afurl;
		return $afurl([
			'tag',
			$this->group_type_name,
			$this->group_label,
		]);
	}




	////////////////////////////////////////////////////////////////////////////
	//OVERWRITE THE PUDL PARAMETERS FOR PULLING A COLLECTION
	////////////////////////////////////////////////////////////////////////////
	protected static function schema() {
		return array_merge_recursive(parent::schema(), [
			'column'	=> ['gt.group_type_name'],

			'table'		=> [
				'gr' => 'pudl_group',
				'gt' => 'pudl_group_type',
			],

			'clause'	=> [
				'gr.group_id' => pudl::column([static::prefix,'group_id']),
				'gr.group_type_id=gt.group_type_id',
			],
		]);
	}




	////////////////////////////////////////////////////////////////////////////
	//LATE STATIC BINDING VARIABLES FROM PUDL ORM
	////////////////////////////////////////////////////////////////////////////
	const	name		= 'group_label';
	const	column		= 'group_label_id';
	const	icon		= 'gr.group_icon';
	const	table		= 'group_label';
	const	prefix		= 'gl';

}
