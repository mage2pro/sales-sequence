<?php
namespace Dfe\SalesSequence\Config\Matrix;
use Df\Config\BackendUnusial;
use Df\Config\Backend as _Backend;
/**
 * 2016-01-11
 * @method mixed|null getValue()
 */
class Backend extends BackendUnusial {
	/**
	 * 2016-01-14
	 * @override
	 * @see \Df\Config\BackendUnusial::afterLoad()
	 * @return $this
	 */
	public function afterLoad() {
		$this->setValue(df_json_encode($this->nextNumbers()));
		return $this;
	}

	/**
	 * 2016-01-11
	 * @override
	 * @see \Df\Config\BackendUnusial::save()
	 * @return $this
	 */
	public function save() {
		return $this;
	}

	/**
	 * 2016-01-11
	 * @return int[][]
	 */
	private function nextNumbers() {
		return array_map(function($storeId) {
			return array_values(array_map(function($entityTypeId) use ($storeId) {
				return df_sales_seq_next($entityTypeId, $storeId);
			}, df_sales_entity_types()));
		}, df_store_ids());
	}
}