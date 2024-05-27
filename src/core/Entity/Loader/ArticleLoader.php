<?php

namespace PccPhpSdk\core\Entity\Loader;

use PccPhpSdk\api\Query\ArticleQueryArgs;
use PccPhpSdk\api\Query\ArticleSearchArgs;
use PccPhpSdk\core\Entity\Article;
use PccPhpSdk\core\Entity\ArticlesList;
use PccPhpSdk\core\PccClient;
use PccPhpSdk\core\Query\Builder\Article\ArticlesListQueryBuilder;
use PccPhpSdk\core\Query\Builder\Article\ArticleQueryBuilder;
use PccPhpSdk\core\Query\QueryInterface;

/**
 * Article Loader.
 */
class ArticleLoader implements ArticleLoaderInterface {

  /**
   *  PccClient.
   *
   * @var PccClient
   */
  protected PccClient $pccClient;

  /**
   * Constructor for Content API.
   *
   * @param PccClient $pccClient
   *   Preconfigured PccClient
   */
  public function __construct(PccClient $pccClient) {
    $this->pccClient = $pccClient;
  }

  /**
   * {@inheritDoc}
   */
  public function loadById(string $id): ?Article {
    $queryBuilder = new ArticleQueryBuilder();
    $queryBuilder->addFields($this->getDefaultFields());
    $queryBuilder->filterById($id);

    $query = $queryBuilder->build();

    $response = $this->sendRequest($query);
    $response = $response['article'] ?: null;
    return !empty($response) ? $this->toArticle($response) : null;
  }

  /**
   * {@inheritDoc}
   */
  public function loadBySlug(string $slug): ?Article {
    $queryBuilder = new ArticleQueryBuilder();
    $queryBuilder->addFields($this->getDefaultFields());
    $queryBuilder->filterBySlug($slug);

    $query = $queryBuilder->build();

    $response = $this->sendRequest($query);
    $response = $response['article'] ?: null;
    return !empty($response) ? $this->toArticle($response) : null;
  }

  /**
   * {@inheritDoc}
   */
  public function loadAll(?ArticleQueryArgs $queryArgs, ?ArticleSearchArgs $searchArgs): ArticlesList {
    $queryBuilder = new ArticlesListQueryBuilder();
    $queryBuilder->addFields($this->getDefaultFields());
    if ($searchArgs) {
      $queryBuilder->setFilter($searchArgs);
    }
    if ($queryArgs) {
      $queryBuilder->setQueryArgs($queryArgs);
    }
    $query = $queryBuilder->build();

    $response = $this->sendRequest($query);
    $response = $response['articles'] ?: [];
    return $this->toArticlesList($response);
  }

  /**
   * Send Request with query.
   *
   * @param QueryInterface $query
   *   Query for the request body.
   *
   * @return array
   *   Response data as array.
   */
  private function sendRequest(QueryInterface $query): array {
    $response = $this->pccClient->executeQuery($query);
    $jsonResponse = json_decode($response, true);
    $result = [];
    if (!empty($jsonResponse) && !empty($jsonResponse['data'])) {
      $result = $jsonResponse['data'];
    }
    return $result;
  }

  /**
   * Parse response to get ArticlesList.
   *
   * @param array $data
   *   Response data.
   *
   * @return ArticlesList
   *   ArticlesList entity.
   */
  private function toArticlesList(array $data): ArticlesList {
    $articlesList = new ArticlesList();
    foreach ($data as $article) {
      $articleEntity = $this->toArticle($article);
      if ($articleEntity instanceof Article) {
        $articlesList->addArticle($articleEntity);
      }
    }

    return $articlesList;
  }

  /**
   * Parse response data to get Article.
   *
   * @param array $data
   *   Response data.
   *
   * @return Article|null
   *   Article entity or null.
   */
  private function toArticle(array $data): ?Article {
    if (empty($data)) {
      return null;
    }

    $article = new Article();
    foreach ($this->getDefaultFields() as $field) {
      switch ($field) {
        case 'tags':
          $article->{$field} = $data[$field] ?: [];
          break;

        default:
          $article->{$field} = $data[$field] ?? '';
      }
    }
    return $article;
  }

  /**
   * Get default article fields.
   *
   * @return string[]
   *   Array of fields.
   */
  protected function getDefaultFields(): array {
    return [
      'id',
      'slug',
      'title',
      'siteId',
      'tags',
      'content',
      'snippet',
      'publishedDate',
      'updatedAt',
    ];
  }

}
