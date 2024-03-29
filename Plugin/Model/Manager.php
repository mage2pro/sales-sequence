<?php
namespace Dfe\SalesSequence\Plugin\Model;
use Dfe\SalesSequence\Settings as S;
use Magento\Framework\DB\Sequence\SequenceInterface as ISequence;
use Magento\SalesSequence\Model\Manager as Sb;
use Magento\SalesSequence\Model\Sequence;
# 2023-08-06
# "Prevent interceptors generation for the plugins extended from interceptable classes":
# https://github.com/mage2pro/core/issues/327
# 2023-12-31
# "Declare as `final` the final classes implemented `\Magento\Framework\ObjectManager\NoninterceptableInterface`"
# https://github.com/mage2pro/core/issues/345
final class Manager extends Sb implements \Magento\Framework\ObjectManager\NoninterceptableInterface {
	/** 2016-01-29 Потрясающая техника. */
	function __construct() {}

	/**
	 * 2016-01-29
	 * Цель перекрытия — настройка форматирования номеров продажных документов.
	 * @see \Magento\SalesSequence\Model\Manager::getSequence()
	 * https://github.com/magento/magento2/blob/720667e/app/code/Magento/SalesSequence/Model/Manager.php#L37-L54
	 */
	function aroundGetSequence(Sb $sb, \Closure $f, string $entityType, int $storeId):ISequence {
		$this->type = $entityType;
		$this->storeId = $storeId;
		return !S::s()->enable($storeId) ? $f($entityType, $storeId) : df_new_om(Sequence::class, [
			'meta' => df_sales_seq_meta($entityType, $storeId), 'pattern' => $this->pattern()
		]);
	}

	/**
	 * 2016-01-30
	 * @used-by self::pattern()
	 */
	private function affix(int $affixId):string {return df_var(
		S::s()->affix($this->type, $affixId, $this->storeId), [
			'STORE-ID' => $this->storeId, 'STORE-CODE' => df_store_code($this->storeId)
		], function($variable) {return date($variable);}
	);}

	/**
	 * 2016-01-29
	 * @used-by self::aroundGetSequence()
	 */
	private function pattern():string {
		/** @var string $pad */ $pad = !S::s()->needPad($this->storeId) ? '' : '0' . S::s()->padLength();
		return "%s{$this->affix(S::PREFIX)}%{$pad}d{$this->affix(S::SUFFIX)}%s";
	}

	/**
	 * 2016-01-30
	 * @var int
	 */
	private $storeId;
	/**
	 * 2016-01-30
	 * @var string
	 */
	private $type;
}