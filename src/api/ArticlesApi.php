<?php

namespace PccPhpSdk\api;

use PccPhpSdk\api\Query\ArticleQueryArgs;
use PccPhpSdk\api\Query\ArticleSearchArgs;
use PccPhpSdk\api\Response\Article;
use PccPhpSdk\api\Response\Builder\ResponseBuilder;
use PccPhpSdk\api\Response\PaginatedArticles;
use PccPhpSdk\core\PccClient;
use PccPhpSdk\core\Services\ArticlesManager;

/**
 * Articles API to fetch articles.
 */
class ArticlesApi extends PccApi {

  /**
   * Internal Articles Manager Service.
   *
   * @var \PccPhpSdk\api\Response\ArticlesManager
   */
  private ArticlesManager $articlesManager;

  /**
   * {@inheritDoc}
   */
  public function __construct(PccClient $pccClient) {
    parent::__construct($pccClient);
    $this->articlesManager = new ArticlesManager($pccClient);
  }

  /**
   * Get all articles (paginated).
   *
   * @param array $fields
   *   The Article fields.
   *
   * @return \PccPhpSdk\api\Response\PaginatedArticles
   *   Returns articles list wrapped as PaginatedArticles.
   *
   * @throws \PccPhpSdk\Exception\PccClientException
   */
  public function getAllArticles(array $fields): PaginatedArticles {
    $articles = $this->articlesManager->getArticles($fields);
    return ResponseBuilder::toPaginatedArticles($articles);
  }

  /**
   * Search Articles.
   *
   * @param array $fields
   *   The Article fields.
   * @param \PccPhpSdk\api\Query\ArticleQueryArgs $queryArgs
   *   Query Args.
   * @param \PccPhpSdk\api\Query\ArticleSearchArgs $searchArgs
   *   Search Criterion.
   *
   * @return \PccPhpSdk\api\Response\PaginatedArticles
   *   Returns articles list matching the search criterion as PaginatedArticles.
   */
  public function searchArticles(array $fields, ?ArticleQueryArgs $queryArgs = null, ?ArticleSearchArgs $searchArgs = null): PaginatedArticles {
    $articles = $this->articlesManager->getArticles($queryArgs, $searchArgs);
    return ResponseBuilder::toPaginatedArticles($articles);
  }

  /**
   * Get article by ID.
   *
   * @param array $fields
   *   The Article fields.
   *
   * @var string $id
   *   The article id.
   *
   * @return \PccPhpSdk\api\Response\Article|null
   *   Return Article response object.
   *
   * @throws \PccPhpSdk\Exception\PccClientException
   */
  public function getArticleById(array $fields, string $id): ?Article {
    $articleEntity = $this->articlesManager->getArticleById($fields, $id);

    return $articleEntity ? ResponseBuilder::toArticleResponse($articleEntity) : NULL;
  }

  /**
   * Get article by slug.
   *
   * @param array $fields
   *   The Article fields.
   *
   * @var string $slug
   *   The article slug.
   *
   * @return \PccPhpSdk\api\Response\Article|null
   *   Return Article response object.
   *
   * @throws \PccPhpSdk\Exception\PccClientException
   */
  public function getArticleBySlug(array $fields, string $slug): ?Article {
    $articleEntity = $this->articlesManager->getArticleBySlug($fields, $slug);
    return $articleEntity ? ResponseBuilder::toArticleResponse($articleEntity) : NULL;
  }

}
