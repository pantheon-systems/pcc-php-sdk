<?php

namespace PccPhpSdk\api;

use PccPhpSdk\api\Query\Enums\ContentType;
use PccPhpSdk\api\Query\Enums\PublishingLevel;
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
   * Get All Articles.
   *
   * @param \PccPhpSdk\api\Query\ArticleQueryArgs $queryArgs
   *   Query Args.
   * @param \PccPhpSdk\api\Query\ArticleSearchArgs $searchArgs
   *   Search Criterion.
   * @param array $fields
   *   The Article fields.
   *
   * @return \PccPhpSdk\api\Response\PaginatedArticles
   *   Returns articles list matching the search criterion as PaginatedArticles.
   */
  public function getAllArticles(?ArticleQueryArgs $queryArgs = NULL, ?ArticleSearchArgs $searchArgs = NULL, array $fields = []): PaginatedArticles {
    $articles = $this->articlesManager->getArticles($queryArgs, $searchArgs, $fields);
    return ResponseBuilder::toPaginatedArticles($articles);
  }

  /**
   * Get article by ID.
   *
   * @param string $id
   *   The article id.
   * @param array $fields
   *   The Article fields.
   * @param PublishingLevel $publishingLevel
   *   The publishing level.
   *
   * @return \PccPhpSdk\api\Response\Article|null
   *   Return Article response object.
   *
   * @throws \PccPhpSdk\Exception\PccClientException
   */
  public function getArticleById(string $id, array $fields = [], PublishingLevel $publishingLevel = PublishingLevel::PRODUCTION, ?ContentType $contentType = null): ?Article {
	$articleEntity = $this->articlesManager->getArticleById(...func_get_args());
    return $articleEntity ? ResponseBuilder::toArticleResponse($articleEntity) : NULL;
  }

  /**
   * Get article by slug.
   *
   * @param string $slug
   *   The article slug.
   * @param array $fields
   *   The Article fields.
   * @param PublishingLevel $publishingLevel
   *   The publishing Level.
   *
   * @return \PccPhpSdk\api\Response\Article|null
   *   Return Article response object.
   *
   * @throws \PccPhpSdk\Exception\PccClientException
   */
  public function getArticleBySlug(string $slug, array $fields = [], PublishingLevel $publishingLevel = PublishingLevel::PRODUCTION): ?Article {
    $articleEntity = $this->articlesManager->getArticleBySlug($slug, $fields, $publishingLevel);
    return $articleEntity ? ResponseBuilder::toArticleResponse($articleEntity) : NULL;
  }

}
