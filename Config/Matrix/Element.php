<?php
namespace Dfe\SalesSequence\Config\Matrix;
use Df\Framework\Form\Element\Hidden;
abstract class Element extends Hidden {
	/**
	 * 2016-01-30
	 * @return string[]
	 */
	abstract protected function columns();

	/**
	 * 2016-01-29
	 * @return string[]
	 */
	abstract protected function rows();

	/**
	 * 2016-01-29
	 * @override
	 * @see \Df\Framework\Form\ElementI::onFormInitialized()
	 * @used-by \Df\Framework\Plugin\Data\Form\Element\AbstractElement::afterSetForm()
	 * @return void
	 */
	function onFormInitialized() {
		df_fe_init($this, __CLASS__, df_asset_third_party('Handsontable/main.css'), [
			'columns' => $this->columns(), 'rows' => $this->rows()
		], 'matrix');
	}
}
