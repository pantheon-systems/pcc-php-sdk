<?php

namespace PccPhpSdk\api;

use PccPhpSdk\query\GraphQLQuery;

/**
 * Site API to get site.
 */
class SiteApi extends PccApi {


  /**
   * Get site.
   *
   * @param string $siteId
   *   Site ID string.
   *
   * @return mixed
   *   Returns site information as JSON.
   */
  public function getSite(string $siteId): mixed {
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
    return $this->pccClient->executeQuery($graphQLQuery);
  }
}
