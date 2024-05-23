<?php

namespace PccPhpSdk\api;

use PccPhpSdk\api\query\ArticleSearchArgs;
use PccPhpSdk\api\response\PaginatedArticles;
use PccPhpSdk\core\PccClient;
use PccPhpSdk\core\query\GraphQLQuery;
use PccPhpSdk\core\services\ArticlesManager;

/**
 * Content API to get articles.
 */
class ArticlesApi extends PccApi {

  private ArticlesManager $articlesManager;

  public function __construct(PccClient $pccClient) {
    parent::__construct($pccClient);
    $this->articlesManager = new ArticlesManager($pccClient);
  }

  /**
   * Get all articles.
   *
   * @return mixed
   *   Returns articles list as JSON.
   *
   * @throws \PccPhpSdk\Exception\PccClientException
   */
  public function getAllArticles(): PaginatedArticles {
    $articles = $this->articlesManager->getArticles();
    $paginatedArticles = new PaginatedArticles();
    $paginatedArticles->articles = $articles;
    $paginatedArticles->total = count($articles);
    return $paginatedArticles;
  }

  public function getArticles(ArticleSearchArgs $args): PaginatedArticles {
    $articles = $this->articlesManager->getArticles($args);
    $response = new PaginatedArticles();
    $response->articles = $articles;
    return $response;
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
