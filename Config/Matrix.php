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
		$this['value'] = df_json_encode([[1, 2, 3, 4], [5, 6, 7, 8], [9, 10, 11, 12]]);
		df_fe_init($this, __CLASS__, 'Df_Core::lib/Handsontable/main.css', [
			'columns' => ['Order', 'Invoice', 'Shipment', 'Credit Memo']
			,'rows' => ['Store 1', 'Store 2', 'Store 3']
		]);
	}
}
