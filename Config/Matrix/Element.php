<?php
namespace Dfe\SalesSequence\Config\Matrix;
/**
 * 2016-01-29
 * @see \Dfe\SalesSequence\Config\Affix\Element
 * @see \Dfe\SalesSequence\Config\Next\Element
 */
abstract class Element extends \Df\Framework\Form\Element\Hidden {
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
	 * @see \Df\Framework\Form\Element\Hidden::onFormInitialized()
	 * @used-by \Df\Framework\Plugin\Data\Form\Element\AbstractElement::afterSetForm()
	 */
	final function onFormInitialized() {df_fe_init(
		$this, __CLASS__, df_asset_third_party('Handsontable/main.css'), [
			'columns' => $this->columns(), 'rows' => $this->rows()
		], 'matrix'
	);}
}
