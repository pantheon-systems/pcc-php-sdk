<?php

namespace PccPhpSdk\api;

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
   *
   * @throws \PccPhpSdk\Exception\PccClientException
   */
  public function getAllArticles(): mixed {
    $query = <<<GRAPHQL
    {
      articles(contentType: TREE_PANTHEON_V2) {
        id
        title
        siteId
        tags
        content
        snippet
        publishedDate
        updatedAt
        slug
      }
    }
    GRAPHQL;

    $graphQLQuery = new GraphQLQuery($query);
    return $this->pccClient->executeQuery($graphQLQuery);
  }

  /**
   * Get all articles.
   *
   * @var string $id
   *   The content id.
   *
   * @return mixed
   *   Returns articles list as JSON.
   *
   * @throws \PccPhpSdk\Exception\PccClientException
   */
  public function getArticleById(string $id): mixed {
    $query = <<<GRAPHQL
    {
      article (id: "$id" contentType: TREE_PANTHEON_V2) {
        id
        title
        siteId
        tags
        content
        snippet
        publishedDate
        updatedAt
        slug
      }
    }
    GRAPHQL;

    $graphQLQuery = new GraphQLQuery($query);
    return $this->pccClient->executeQuery($graphQLQuery);
  }

  /**
   * Get all articles.
   *
   * @var string $slug
   *   The content slug.
   *
   * @return mixed
   *   Returns articles list as JSON.
   *
   * @throws \PccPhpSdk\Exception\PccClientException
   */
  public function getArticleBySlug(string $slug): mixed {
    $query = <<<GRAPHQL
    {
      article(slug: "$slug" contentType: TREE_PANTHEON_V2) {
        id
        title
        siteId
        tags
        content
        snippet
        publishedDate
        updatedAt
        slug
      }
    }
    GRAPHQL;

    $graphQLQuery = new GraphQLQuery($query);
    return $this->pccClient->executeQuery($graphQLQuery);
  }

}
