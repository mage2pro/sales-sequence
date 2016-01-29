<?php
namespace Dfe\SalesSequence;
use Magento\Framework\App\ScopeInterface;
class Settings extends \Df\Core\Settings {
	/**
	 * 2016-01-29
	 * «Mage2.PRO» → «Sales» → «Documents Numeration» → «Enable?»
	 * @param null|string|int|ScopeInterface $scope [optional]
	 * @return bool
	 */
	public function enable($scope = null) {return $this->b(__FUNCTION__, $scope);}

	/**
	 * 2016-01-29
	 * «Mage2.PRO» → «Sales» → «Documents Numeration» → «Pad Numbers with Leading Zeros?»
	 * @param null|string|int|ScopeInterface $scope [optional]
	 * @return bool
	 */
	public function needPad($scope = null) {return $this->b(__FUNCTION__, $scope);}

	/**
	 * 2016-01-29
	 * «Mage2.PRO» → «Sales» → «Documents Numeration» → «Numbers Length»
	 * @param null|string|int|ScopeInterface $scope [optional]
	 * @return int
	 */
	public function padLength($scope = null) {return $this->i(__FUNCTION__, $scope);}

	/**
	 * @override
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_sales/documents_numeration/';}

	/** @return $this */
	public static function s() {static $r; return $r ? $r : $r = df_o(__CLASS__);}
}