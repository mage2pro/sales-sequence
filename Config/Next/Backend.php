<?php
namespace Dfe\SalesSequence\Config\Next;
use Df\Config\Backend\Unusial\Model;
use Df\Config\Backend as _Backend;
/**
 * 2016-01-11
 * @method mixed|null getValue()
 */
class Backend extends Model {
	/**
	 * 2016-01-14
	 * @override
	 * @see \Df\Config\Backend\Unusial\Model::afterLoad()
	 * @return $this
	 */
	function afterLoad() {
		$this->setValue(df_json_encode($this->nextNumbersFromDb()));
		return $this;
	}

	/**
	 * 2016-01-26
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
		/** @var int[][] $valuesFromUi */
		$valuesFromUi = df_json_decode($this->getValue());
		/** @var int[][] $valuesFromDb */
		$valuesFromDb = $this->nextNumbersFromDb();
		/** @var int[] $storeIds */
		$storeIds = df_store_ids();
		/** @var int $numStores */
		$numStores = count($storeIds);
		/** @var int[] $types */
		// 2016-01-27
		// Нам нужно, чтобы у массива были целочисленные ключи.
		$types = array_values(df_sales_entity_types());
		/** @var int $numTypes */
		$numTypes = count($types);
		for ($storeIndex = 0; $storeIndex < $numStores; $storeIndex++) {
			/** @var int $storeIndex */
			for ($typeIndex = 0; $typeIndex < $numTypes; $typeIndex++) {
				/** @var int $typeIndex */
				/** @var int $valueFromUi */
				$valueFromUi = (int)$valuesFromUi[$storeIndex][$typeIndex];
				/** @var int $valueFromDb */
				$valueFromDb = (int)$valuesFromDb[$storeIndex][$typeIndex];
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
	private function nextNumbersFromDb() {
		return array_map(function($storeId) {
			return array_values(array_map(function($entityTypeId) use ($storeId) {
				return df_sales_seq_next($entityTypeId, $storeId);
			}, df_sales_entity_types()));
		}, df_store_ids());
	}

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