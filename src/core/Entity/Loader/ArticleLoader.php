<?php

namespace PccPhpSdk\core\Entity\Loader;

use PccPhpSdk\core\Entity\Article;
use PccPhpSdk\core\Entity\ArticlesList;
use PccPhpSdk\core\PccClient;
use PccPhpSdk\core\Query\Builder\ArticleQueryBuilder;
use PccPhpSdk\core\Query\Builder\ArticlesListQueryBuilder;
use PccPhpSdk\core\Query\QueryInterface;

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

  public function loadById(string $id): ?Article {
    $queryBuilder = new ArticleQueryBuilder();
    $queryBuilder->addFields($this->getDefaultFields());
    $queryBuilder->filterById($id);

    $query = $queryBuilder->build();

    $response = $this->sendRequest($query);
    $response = $response['article'] ?: null;
    return !empty($response) ? $this->toArticle($response) : null;
  }

  public function loadBySlug(string $slug): ?Article {
    $queryBuilder = new ArticleQueryBuilder();
    $queryBuilder->addFields($this->getDefaultFields());
    $queryBuilder->filterBySlug($slug);

    $query = $queryBuilder->build();

    $response = $this->sendRequest($query);
    $response = $response['article'] ?: null;
    return !empty($response) ? $this->toArticle($response) : null;
  }

  public function loadAll(): ArticlesList {
    $queryBuilder = new ArticlesListQueryBuilder();
    $queryBuilder->addFields($this->getDefaultFields());
    $query = $queryBuilder->build();

    $response = $this->sendRequest($query);
    $response = $response['articles'] ?: [];
    return $this->toArticlesList($response);
  }

  private function sendRequest(QueryInterface $query): array {
    $response = $this->pccClient->executeQuery($query);
    $jsonResponse = json_decode($response, true);
    $result = [];
    if (!empty($jsonResponse) && !empty($jsonResponse['data'])) {
      $result = $jsonResponse['data'];
    }
    return $result;
  }

  private function toArticlesList(array $data): ArticlesList {
    $articlesList = new ArticlesList();
    foreach ($data as $article) {
      $articlesList->addArticle($this->toArticle($article));
    }

    return $articlesList;
  }

  private function toArticle(array $data): ?Article {
    if (empty($data)) {
      return null;
    }

    $article = new Article();
    foreach ($this->getDefaultFields() as $field) {
      if (isset($data[$field])) {
        $article->{$field} = $data[$field];
      }
    }
    return $article;
  }

  private function getDefaultFields(): array {
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