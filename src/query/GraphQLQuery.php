<?php

namespace PccPhpSdk\query;

use ArrayObject;

/**
 * GraphQL Query class.
 */
class GraphQLQuery implements QueryInterface {

  /**
   * Query string.
   *
   * @var string
   */
  private string $query;

  /**
   * Variables Array.
   *
   * @var ArrayObject
   */
  private ArrayObject $variables;

  public function __construct(string $query, ArrayObject $variables = new ArrayObject()) {
    $this->query = $query;
    $this->variables = $variables;
  }

  /**
   * @inheritDoc
   */
  public function build(): string {
    return json_encode(
      [
        'query' => $this->query,
        'variables' => $this->variables
      ]
    );
  }

  /**
   * Set query string.
   *
   * @param string $query
   *   Query string.
   *
   * @return void
   *   Returns void.
   */
  public function setQuery(string $query): void {
    $this->query = $query;
  }

  /**
   * Set variables array.
   *
   * @param ArrayObject $variables
   *   Variables Array object.
   *
   * @return void
   *   Returns void.
   */
  public function setVariables(ArrayObject $variables): void {
    $this->variables = $variables;
  }
}
