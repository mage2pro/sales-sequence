<?php
namespace Dfe\SalesSequence\Plugin\Model;
use Dfe\SalesSequence\Settings as S;
use Magento\SalesSequence\Model\Manager as Sb;
use Magento\SalesSequence\Model\Sequence;
class Manager extends Sb {
	/**
	 * 2016-01-29
	 * Потрясающая техника.
	 */
	public function __construct() {}

	/**
	 * 2016-01-29
	 * Цель перекрытия — настройка форматирования номеров продажных документов.
	 * @see \Magento\SalesSequence\Model\Manager::getSequence()
	 * https://github.com/magento/magento2/blob/720667e/app/code/Magento/SalesSequence/Model/Manager.php#L37-L54
	 * @param Sb $sb
	 * @param \Closure $proceed
	 * @param string $entityType
	 * @param int $storeId
	 * @return \Magento\Framework\DB\Sequence\SequenceInterface
	 */
	public function aroundGetSequence(Sb $sb, \Closure $proceed, $entityType, $storeId) {
		/** @var \Magento\Framework\DB\Sequence\SequenceInterface $result */
		if (!S::s()->enable($storeId)) {
			$result = $proceed($entityType, $storeId);
		}
		else {
			$result = df_create(Sequence::class, [
				'meta' => df_sales_seq_meta($entityType, $storeId)
				,'pattern' => $this->pattern($storeId)
			]);
		}
		return $result;
	}

	/**
	 * 2016-01-29
	 * @param int $storeId
	 * @return string
	 */
	private function pattern($storeId) {
		/** @var string $result */
		if (!S::s()->enable($storeId) || !S::s()->needPad($storeId)) {
			$result = Sequence::DEFAULT_PATTERN;
		}
		else {
			/**
			 * 2016-01-29
			 * https://mage2.pro/t/574
			 * «The @see \Magento\SalesSequence\Model\Sequence::DEFAULT_PATTERN constant
			 * can be simplified».
			 */
			$result = "%s%0" . S::s()->padLength() . "d%s";
		}
		return $result;
	}
}