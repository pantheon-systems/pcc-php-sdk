<?php

namespace PccPhpSdk\api;

use PccPhpSdk\core\PantheonClient;
use PccPhpSdk\query\GraphQLQuery;

class SiteApi {
  private PantheonClient $pantheonClient;

  public function __construct(PantheonClient $pantheonClient) {
    $this->pantheonClient = $pantheonClient;
  }

  public function getSite($siteId) {
    $query = <<<'GRAPHQL'
    query GetSite($siteId: String!) {
      site(id: $siteId) {
        id
        url
      }
    }
    GRAPHQL;
    $variables = new \ArrayObject(['siteId' => $siteId]);

    $graphQLQuery = new GraphQLQuery($query, $variables);
    return $this->pantheonClient->executeQuery($graphQLQuery);
  }
}