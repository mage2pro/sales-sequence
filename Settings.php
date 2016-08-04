<?php
namespace Dfe\SalesSequence;
use Magento\Framework\App\ScopeInterface as S;
/** @method static Settings s() */
class Settings extends \Df\Core\Settings {
	/**
	 * 2016-01-29
	 * «Mage2.PRO» → «Sales» → «Documents Numeration» → «Numbers Length»
	 * @param string $type
	 * @param int $affixId
	 * @param null|string|int|S $scope [optional]
	 * @return string
	 */
	public function affix($type, $affixId, $scope = null) {
		return df_nts($this->_matrix(__FUNCTION__, df_sales_entity_type_index($type), $affixId, $scope));
	}

	/**
	 * 2016-01-29
	 * «Mage2.PRO» → «Sales» → «Documents Numeration» → «Pad Numbers with Leading Zeros?»
	 * @param null|string|int|S $scope [optional]
	 * @return bool
	 */
	public function needPad($scope = null) {return $this->b(__FUNCTION__, $scope);}

	/**
	 * 2016-01-29
	 * «Mage2.PRO» → «Sales» → «Documents Numeration» → «Numbers Length»
	 * @param null|string|int|S $scope [optional]
	 * @return int
	 */
	public function padLength($scope = null) {return $this->i(__FUNCTION__, $scope);}

	/**
	 * @override
	 * @see \Df\Core\Settings::prefix()
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_sales/documents_numeration/';}

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