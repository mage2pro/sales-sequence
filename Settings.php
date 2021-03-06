<?php
namespace Dfe\SalesSequence;
use Magento\Framework\App\ScopeInterface as S;
/** @method static Settings s() */
final class Settings extends \Df\Config\Settings {
	/**
	 * 2016-01-29 «Mage2.PRO» → «Sales» → «Documents Numeration» → «Numbers Length»
	 * @param string $type
	 * @param int $affixId
	 * @param null|string|int|S $s [optional]
	 * @return string
	 */
	function affix($type, $affixId, $s = null) {return df_nts($this->_matrix(
		df_sales_entity_type_index($type), $affixId, __FUNCTION__, $s
	));}

	/**
	 * 2016-01-29
	 * «Mage2.PRO» → «Sales» → «Documents Numeration» → «Pad Numbers with Leading Zeros?»
	 * @param null|string|int|S $s [optional]
	 * @return bool
	 */
	function needPad($s = null) {return $this->b(null, $s);}

	/**
	 * 2016-01-29
	 * «Mage2.PRO» → «Sales» → «Documents Numeration» → «Numbers Length»
	 * @param null|string|int|S $s [optional]
	 * @return int
	 */
	function padLength($s = null) {return $this->i(null, $s);}

	/**
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_sales/documents_numeration';}

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