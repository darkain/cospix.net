<?php

class cpnTag {


	static function get($table, $clause) {
		global $db;

		return $db->select(
			['gl.*', 'gt.*', 'th.thumb_hash'],
			array_merge($table, [
				'gl' => 'pudl_group_label',
				'gr' => _pudl_group(50),
				'gt' => 'pudl_group_type',
			]),
			array_merge($clause, [
				'gr.group_id=gl.group_id',
				'gr.group_type_id=gt.group_type_id',
			]),
			['group_type_id', 'group_type_name']
		);
	}



	static function getObject($id, $type=false) {
		if (is_array($id)) {
			$type	= $id['object_type_id'];
			$id		= $id['object_id'];
		}

		return self::get([
			'ol' => 'pudl_object_label',
		], [
			'ol.group_label_id=gl.group_label_id',
			'ol.object_id'		=> $id,
			'ol.object_type_id'	=> self::type($type),
		]);
	}



	static function getHash($hash, $type) {
		if (is_array($hash)) {
			$type	= $hash['file_hash'];
			$hash	= $hash['object_id'];
		}

		return self::get([
			'ol' => 'pudl_object_label',
		], [
			'ol.group_label_id=gl.group_label_id',
			'ol.file_hash'		=> $hash,
			'ol.object_type_id'	=> self::type($type),
		]);
	}



	static function getImage($hash, $type=false) {
		if ($type === false) $type = self::type('gallery');

		return self::get([
			'gi' => 'pudl_gallery_image',
			'ol' => 'pudl_object_label',
		], [
			'ol.group_label_id=gl.group_label_id',
			'ol.object_id=gi.gallery_id',
			'ol.object_type_id'	=> is_int($type) ? $type : self::type($type),
			'gi.file_hash'		=> $hash,
		]);
	}



	static function getItem($id, $type, $group_type) {
		global $db;

		return $db->row([
			'ol' => 'pudl_object_label',
			'gl' => 'pudl_group_label',
			'gr' => 'pudl_group',
			'gt' => 'pudl_group_type',
		], [
			'ol.group_label_id=gl.group_label_id',
			'gl.group_id=gr.group_id',
			'gr.group_type_id=gt.group_type_id',
			'ol.object_id'			=> $id,
			'ol.object_type_id'		=> is_int($type) ? $type : self::type($type),
			'gt.group_type_name'	=> $group_type,
		]);
	}



	static function getFileImage($hash) {
		global $db;

		$gallery	= self::type('gallery');
		$image		= self::type('image');

		$db->unionStart();
		self::getImage(	$hash, $gallery);
		self::getHash(	$hash, $image);
		return $db->unionEnd(['group_type_id', 'group_label']);
	}



	static function insertObject($id, $type, $tag) {
		global $db, $user;

		$db->insert('pudl_object_label', [
			'object_id'					=> $id,
			'object_type_id'			=> self::type($type),
			'group_label_id'			=> $tag,
			'object_label_timestamp'	=> $db->time(),
			'object_label_user'			=> $user['user_id'],
		], 'object_id=object_id');
	}



	static function deleteObject($id, $type=false, $tag=false) {
		global $db;

		if (is_array($id)) {
			$tag	= $id['group_label_id'];
			$type	= $id['object_type_id'];
			$id		= $id['object_id'];
		}

		$db->delete('pudl_object_label', [
			'object_id'					=> $id,
			'object_type_id'			=> self::type($type),
			'group_label_id'			=> $tag,
		]);
	}


	//TODO: DELETE OBJECT CATEGORY - SEARCH ALL LABELS OF 'TYPE', THEN DELETE ALL
	//		EX: DELETE ALL 'SERIES' LABELS FROM A GALLERY



	static function insertHash($hash, $type, $tag) {
		global $db, $user;

		$db->insert('pudl_object_label', [
			'file_hash'					=> $hash,
			'object_type_id'			=> self::type($type),
			'group_label_id'			=> $tag,
			'object_label_timestamp'	=> $db->time(),
			'object_label_user'			=> $user['user_id'],
		], 'file_hash=file_hash');
	}



	static function deleteHash($hash, $type, $tag) {
		global $db;

		$db->insert('pudl_object_label', [
			'file_hash'					=> $hash,
			'object_type_id'			=> self::type($type),
			'group_label_id'			=> $tag,
		]);
	}



	static function insertLabel($label, $type) {
		global $db;

		//Fix URL crap
		$label	= afString::slash(trim($label));
		$type	= trim($type);

		//Check if object already exists
		$id = $db->cell([
			'gr' => 'pudl_group',
			'gl' => 'pudl_group_label',
			'gt' => 'pudl_group_type'
		], 'group_label_id', [
			'gl.group_id=gr.group_id',
			'gr.group_type_id=gt.group_type_id',
			'gl.group_label'		=> $label,
			'gt.group_type_name'	=> $type,
		]);
		if (!empty($id)) return $id;

		//Pull the Type ID
		$typeid = $db->cellId('pudl_group_type', 'group_type_id', 'group_type_name', $type);
		if (empty($typeid)) return false;

		//Insert the object
		$group_id = $db->insert('pudl_group', [
			'group_type_id'		=> $typeid,
			'group_approved'	=> '1',
		]);

		//Insert the object's label
		return $db->insert('pudl_group_label', [
			'group_id'		=> $group_id,
			'group_label'	=> $label,
			'lang_id'		=> afString::language($label),
		]);
	}



	static function type($type) {
		global $af;
		if (is_int($type))		return $type;
		if (ctype_digit($type))	return $type;
		return $af->type($type);
	}

}
