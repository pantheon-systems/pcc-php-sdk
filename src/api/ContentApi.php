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
    $query = <<<'GRAPHQL'
    query{
      articles {
        id
        title
      }
    }
    GRAPHQL;

    $graphQLQuery = new GraphQLQuery($query);
    return $this->pantheonClient->executeQuery($graphQLQuery);
  }
}
