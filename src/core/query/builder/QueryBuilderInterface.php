<?php

namespace PccPhpSdk\core\query\builder;

use PccPhpSdk\core\query\QueryInterface;

/**
 *
 */
interface QueryBuilderInterface {

  /**
   * @param string $fieldName
   * @return QueryBuilderInterface
   */
  public function addField(string $fieldName) : QueryBuilderInterface;

  /**
   * @param array $fieldNames
   * @return QueryBuilderInterface
   */
  public function addFields(array $fieldNames) : QueryBuilderInterface;

  /**
   * @return QueryInterface
   */
  public function build(): QueryInterface;
}
