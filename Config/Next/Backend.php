<?php
namespace Dfe\SalesSequence\Config\Next;
use Df\Config\Backend\Unusial\Model;
use Df\Config\Backend as _Backend;
/**
 * 2016-01-11
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * @method mixed|null getValue()
 */
class Backend extends Model {
	/**
	 * 2016-01-14
	 * @override
	 * @see \Df\Config\Backend\Unusial\Model::afterLoad()
	 * @used-by \Magento\Config\Block\System\Config\Form::getFieldData()
	 *		if ($field->hasBackendModel()) {
	 *			$backendModel = $field->getBackendModel();
	 *			$backendModel->setPath($path)
	 *				->setValue($data)
	 *				->setWebsite($this->getWebsiteCode())
	 *				->setStore($this->getStoreCode())
	 *				->afterLoad();
	 *			$data = $backendModel->getValue();
	 *		}
	 * https://github.com/magento/magento2/blob/2.2.0-RC1.8/app/code/Magento/Config/Block/System/Config/Form.php#L436-L444
	 * @return $this
	 */
	function afterLoad() {return $this->setValue(df_json_encode($this->nextNumbersFromDb()));}

	/**
	 * 2016-01-26
	 * 2017-08-09 It looks like it is never used.  
	 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
	 * @override
	 * @see \Df\Config\Backend\Unusial\Model::delete()
	 * @return $this
	 */
	function delete() {return $this;}

	/**
	 * 2016-01-11
	 * 2016-01-27
	 * Мы не можем выполнить наши задачи внутри метода save(),
	 * потому что нам нужно изменить значение AUTO INCREMENT, а это недопустимо внутри транзакции
	 * «Something went wrong while saving this configuration:
	 * User Error: DDL statements are not allowed in transactions».
	 * @override
	 * @see \Magento\Framework\Model\AbstractModel::afterCommitCallback()
	 * @used-by \Df\Config\Backend\Unusial\Model::save()
	 * @return $this
	 */
	function afterCommitCallback() {
		$valuesFromUi = df_json_decode($this->getValue()); /** @var int[][] $valuesFromUi */
		$valuesFromDb = $this->nextNumbersFromDb(); /** @var int[][] $valuesFromDb */
		$storeIds = df_store_ids(); /** @var int[] $storeIds */
		$numStores = count($storeIds); /** @var int $numStores */
		# 2016-01-27 Нам нужно, чтобы у массива были целочисленные ключи.
		$types = array_values(df_sales_entity_types()); /** @var int[] $types */
		$numTypes = count($types); /** @var int $numTypes */
		for ($storeIndex = 0; $storeIndex < $numStores; $storeIndex++) { /** @var int $storeIndex */
			for ($typeIndex = 0; $typeIndex < $numTypes; $typeIndex++) { /** @var int $typeIndex */
				$valueFromUi = (int)$valuesFromUi[$storeIndex][$typeIndex]; /** @var int $valueFromUi */
				$valueFromDb = (int)$valuesFromDb[$storeIndex][$typeIndex]; /** @var int $valueFromDb */
				if ($valueFromUi !== $valueFromDb) {
					$this->updateNextNumber($storeIds[$storeIndex], $types[$typeIndex], $valueFromUi);
				}
			}
		}
		return $this;
	}

	/**
	 * 2016-01-11
	 * @return int[][]
	 */
	private function nextNumbersFromDb() {return array_map(function($storeId) {return
		array_values(array_map(function($entityTypeId) use($storeId) {return
			df_sales_seq_next($entityTypeId, $storeId)
		;}, df_sales_entity_types()));
	}, df_store_ids());}

	/**
	 * 2016-01-26
	 * @param int $storeId
	 * @param string $entityTypeCode
	 * @param int $nextNumber
	 */
	private function updateNextNumber($storeId, $entityTypeCode, $nextNumber) {
		/** @var string $table */
		$table = df_sales_seq_meta($entityTypeCode, $storeId)->getSequenceTable();
		df_next_increment_set($table, max(df_fetch_col_max($table, 'sequence_value'), $nextNumber));
	}
}