<?php

require_once('_altaform/modules/product.php');

class cpnProduct extends \af\product {

	public function recommended($id=false) {
		global $user, $db;


		$data = [
			['group_label' => 'Sailor Moon'],
			['group_label' => 'Attack on Titan'],
			['group_label' => 'Dragon Ball Z'],
			['group_label' => 'Kill La Kill'],
			//['group_label' => 'sailor moon'],
		];


		/////////////////////////////////////////////
		// TRY USER'S FAVORITE SERIES FIRST
		/////////////////////////////////////////////
		if (!$id) $id = $user['user_id'];

		if ($id) {
			$result = $db->cache(AF_HOUR)->group(
				[
					'gl.*',
					'th.thumb_hash',
					'count' => pudl::count(),
				],
				[
					'ga1' => 'pudl_gallery',
					'gi1' => 'pudl_gallery_image',
					'gi2' => 'pudl_gallery_image',
					'ga2' => 'pudl_gallery',
					'gl'  => 'pudl_group_label',
					'gr'  => _pudl_group(50),
				],
				[
					'ga1.user_id' => $id,
					'gi1.gallery_id=ga1.gallery_id',
					'gi1.file_hash=gi2.file_hash',
					'ga2.gallery_id=gi2.gallery_id',
					'gl.group_label_id=ga2.series_id',
					'gr.group_id=gl.group_id',
				],
				'gl.group_id',
				['count'=>pudl::dsc()],
				10
			);

			$data += $result->rows();
			$result->free();
		}


		/////////////////////////////////////////////
		// NEXT TRY TRENDING SERIES ACROSS WHOLE SITE
		/////////////////////////////////////////////
		$result = $db->cache(AF_HOUR)->orderGroupEx(
			[
				'group_label',
				'group_type_name',
				'group_label_id',
				'gallery_timestamp',
				'thumb_hash',
				'count' => pudl::count(),
			],
			[
				'ga' => 'pudl_gallery',
				'gi' => 'pudl_gallery_image',
				'gl' => 'pudl_group_label',
				'gr' => _pudl_group(50),
				'gt' => 'pudl_group_type',
			],
			[
				'gi.gallery_id=ga.gallery_id',
				'ga.series_id=gl.group_label_id',
				'gl.group_id=gr.group_id',
				'gr.group_type_id=gt.group_type_id',
				'ga.gallery_timestamp' => pudl::gt( \af\time::from(AF_WEEK*2, AF_HOUR) ),
			],
			'ga.gallery_id',
			'group_label_id',
			['count'=>pudl::dsc(), 'gallery_timestamp'=>pudl::dsc()],
			20
		);

		$data += $result->rows();
		$result->free();



		/////////////////////////////////////////////
		// RETURN AN ITEM AT RANDOM!
		/////////////////////////////////////////////
		shuffle($data);
		foreach ($data as &$item) {
			if (strtolower($item['group_label']) === 'league of legends') continue;
			$products = $this->cached($item['group_label']);
			if (!empty($products)) return $products;
		} unset($item);



		/////////////////////////////////////////////
		// YOU SUCK AT THIS
		/////////////////////////////////////////////
		return false;
	}



	public function suggest() {
		$product	= [];
		$data		= $this->recommended();

		if (!empty($data['Items']['Item'])) {
			$products = &$data['Items']['Item'];
			shuffle($products);
			foreach ($products as &$item) {
				if (count($product) > 7) break;
				if (empty($item['DetailPageURL'])) continue;
				if (empty($item['ItemAttributes']['Title'])) continue;
				$image = $this->image($item);
				if (!$image) continue;

				$product[] = [
					'url'	=> $item['DetailPageURL'],
					'name'	=> $item['ItemAttributes']['Title'],
					'image'	=> $image,
				];
			} unset($item);
		}

		return $product;
	}

}
