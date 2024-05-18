<?php

namespace PccPhpSdk\api;

use PccPhpSdk\core\PantheonClient;
use PccPhpSdk\query\GraphQLQuery;

class ContentApi {

  private PantheonClient $pantheonClient;

  public function __construct(PantheonClient $pantheonClient) {
    $this->pantheonClient = $pantheonClient;
  }

  public function getAllArticles() {
    $query = new GraphQLQuery(
      '{\\n    articles {\\n        id\\n        title\\n    }\\n}',
      []
    );
    return $this->pantheonClient->executeQuery($query);
  }
}
