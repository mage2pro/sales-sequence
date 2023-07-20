<?php
namespace Dfe\SalesSequence;
use Magento\Framework\App\ScopeInterface as S;
/** @method static Settings s() */
final class Settings extends \Df\Config\Settings {
	/**
	 * 2016-01-29 «Mage2.PRO» → «Sales» → «Documents Numeration» → «Numbers Length»
	 * @param null|string|int|S $s [optional]
	 */
	function affix(string $type, int $affixId, $s = null):string {return df_nts($this->_matrix(
		df_sales_entity_type_index($type), $affixId, __FUNCTION__, $s
	));}

	/**
	 * 2016-01-29 «Mage2.PRO» → «Sales» → «Documents Numeration» → «Pad Numbers with Leading Zeros?»
	 * 2023-07-20
	 * «Df\Config\Settings::b(): Argument #1 ($k) must be of type string, null given»:
	 * https://github.com/mage2pro/core/issues/240
	 * @param null|string|int|S $s [optional]
	 */
	function needPad($s = null):bool {return $this->b('', $s);}

	/**
	 * 2016-01-29 «Mage2.PRO» → «Sales» → «Documents Numeration» → «Numbers Length»
	 * @param null|string|int|S $s [optional]
	 */
	function padLength($s = null):int {return $this->i('', $s);}

	/**
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 */
	protected function prefix():string {return 'df_sales/documents_numeration';}

	/**
	 * 2016-01-30
	 * @used-by \Dfe\SalesSequence\Settings::affix()
	 * @used-by \Dfe\SalesSequence\Plugin\Model\Manager::pattern()
	 */
	const PREFIX = 0;
	/**
	 * 2016-01-30
	 * @used-by \Dfe\SalesSequence\Settings::affix()
	 * @used-by \Dfe\SalesSequence\Plugin\Model\Manager::pattern()
	 */
	const SUFFIX = 1;
}