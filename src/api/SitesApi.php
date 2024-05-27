<?php

namespace PccPhpSdk\api;

use PccPhpSdk\core\Query\GraphQLQuery;
use PccPhpSdk\Exception\PccClientException;

/**
 * Site API to get site.
 */
class SitesApi extends PccApi {

  /**
   * Get site.
   *
   * @param string $siteId
   *   Site ID string.
   *
   * @return mixed
   *   Returns site information as JSON.
   * @throws PccClientException
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
