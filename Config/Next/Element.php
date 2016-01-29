<?php
namespace Dfe\SalesSequence\Config\Next;
use Dfe\SalesSequence\Config\Matrix\Element as _Element;
class Element extends _Element {
	/**
	 * 2016-01-29
	 * @override
	 * @see \Dfe\SalesSequence\Config\Matrix\Element::rows()
	 * @used-by \Dfe\SalesSequence\Config\Matrix\Element::onFormInitialized()
	 * 2016-01-11
	 * array_values надо ставить обязательно,
	 * потому что когда опция Handsontable rowHeaders
	 * у ассоциативного массива берёт почему-то ключи, а не значения.
	 * http://docs.handsontable.com/0.20.2/Options.html#rowHeaders
	 * @return string[]
	 */
	protected function rows() {return array_values(df_store_names());}
}
