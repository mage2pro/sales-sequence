<?php
namespace Dfe\SalesSequence\Config\Matrix;
use Df\Framework\Data\Form\Element\Hidden;
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
	 * @see \Df\Framework\Data\Form\ElementI::onFormInitialized()
	 * @used-by \Df\Framework\Plugin\Data\Form\Element\AbstractElement::afterSetForm()
	 * @return void
	 */
	public function onFormInitialized() {
		df_fe_init($this, __CLASS__, 'Df_Core::lib/Handsontable/main.css', [
			'columns' => $this->columns(), 'rows' => $this->rows()
		], 'matrix');
	}
}
