<?php
namespace Dfe\SalesSequence\Config;
use Df\Framework\Data\Form\Element\Hidden;
class Matrix extends Hidden {
	/**
	 * 2016-01-10
	 * @override
	 * @see \Df\Framework\Data\Form\ElementI::onFormInitialized()
	 * @used-by \Df\Framework\Plugin\Data\Form\Element\AbstractElement::afterSetForm()
	 * @return void
	 */
	public function onFormInitialized() {
		$this['value'] = df_json_encode($this->nextNumbers());
		df_fe_init($this, __CLASS__, 'Df_Core::lib/Handsontable/main.css', [
			'columns' => array_keys(df_sales_entity_types())
			// 2016-01-11
			// array_values надо ставить обязательно,
			// потому что когда опция Handsontable rowHeaders
			// у ассоциативного массива берёт почему-то ключи, а не значения.
			// http://docs.handsontable.com/0.20.2/Options.html#rowHeaders
			,'rows' => array_values(df_store_names())
		]);
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
