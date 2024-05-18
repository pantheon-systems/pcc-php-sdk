<?php

namespace PccPhpSdk\query;

class GraphQLQuery implements QueryInterface {

  private string $query;
  private array $variables;

  public function __construct(string $query, array $variables = []) {
    $this->query = $query;
    $this->variables = $variables;
  }

  public function build()
  {
    return json_encode(
      [
        'query' => $this->query,
        'variables' => $this->variables
      ]
    );
  }
  
  public function setQuery(string $query) {
    $this->query = $query;
  }

  public function setVariables(array $variables) {
    $this->variables = $variables;
  }
}
