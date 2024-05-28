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
   * @var ArticlesManager $articlesManager
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
   * @return PaginatedArticles
   *   Returns articles list wrapped as PaginatedArticles.
   *
   * @throws \PccPhpSdk\Exception\PccClientException
   */
  public function getAllArticles(): PaginatedArticles {
    $articles = $this->articlesManager->getArticles();
    return ResponseBuilder::toPaginatedArticles($articles);
  }

  /**
   * Search Articles.
   *
   * @param ArticleQueryArgs|null $queryArgs
   *   Query Args.
   * @param ArticleSearchArgs|null $searchArgs
   *   Search Criterion.
   *
   * @return PaginatedArticles
   *   Returns articles list matching the search criterion as PaginatedArticles.
   */
  public function searchArticles(?ArticleQueryArgs $queryArgs = null, ?ArticleSearchArgs $searchArgs = null): PaginatedArticles {
    $articles = $this->articlesManager->getArticles($queryArgs, $searchArgs);
    return ResponseBuilder::toPaginatedArticles($articles);
  }

  /**
   * Get article by ID.
   *
   * @var string $id
   *   The article id.
   *
   * @return Article|null
   *   Return Article response object.
   *
   * @throws \PccPhpSdk\Exception\PccClientException
   */
  public function getArticleById(string $id): ?Article {
    $articleEntity = $this->articlesManager->getArticleById($id);
    return ResponseBuilder::toArticleResponse($articleEntity);
  }

  /**
   * Get article by slug.
   *
   * @var string $slug
   *   The article slug.
   *
   * @return Article|null
   *   Return Article response object.
   *
   * @throws \PccPhpSdk\Exception\PccClientException
   */
  public function getArticleBySlug(string $slug): ?Article {
    $articleEntity = $this->articlesManager->getArticleBySlug($slug);
    return ResponseBuilder::toArticleResponse($articleEntity);
  }

}
