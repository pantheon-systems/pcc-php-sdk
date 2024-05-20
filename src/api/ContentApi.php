<?php

namespace PccPhpSdk\api;

use PccPhpSdk\Exception\PccClientException;
use PccPhpSdk\query\GraphQLQuery;

/**
 * Content API to get articles.
 */
class ContentApi extends PccApi {

  /**
   * Get all articles.
   *
   * @return mixed
   *   Returns articles list as JSON.
   * @throws PccClientException
   */
  public function getAllArticles(): mixed {
    $query = <<<'GRAPHQL'
    query{
      articles {
        id
        title
      }
    }
    GRAPHQL;

    $graphQLQuery = new GraphQLQuery($query);
    return $this->pccClient->executeQuery($graphQLQuery);
  }
}
