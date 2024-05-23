<?php

namespace PccPhpSdk\core\services;

use PccPhpSdk\api\query\ArticleSearchArgs;
use PccPhpSdk\api\response\Article;
use PccPhpSdk\api\response\PaginatedArticles;
use PccPhpSdk\core\PccClient;
use PccPhpSdk\core\query\builder\ArticlesQueryBuilder;
use PccPhpSdk\core\query\QueryInterface;

class ArticlesManager {

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

  public function getArticles(?ArticleSearchArgs $args = null): array {
    $queryBuilder = new ArticlesQueryBuilder();
    $queryBuilder->addFields($this->getDefaultFields());
    $query = $queryBuilder->build();

    $response = $this->sendRequest($query);
    return $this->prepareResponse($response);
  }

  private function sendRequest(QueryInterface $query) {
    $response = $this->pccClient->executeQuery($query);
    $jsonResponse = json_decode($response, true);
    $result = [];
    if (!empty($jsonResponse) && !empty($jsonResponse['data']['articles'])) {
      $result = $jsonResponse['data']['articles'];
    }
    return $result;
  }

  private function prepareResponse(array $response): array {
    $articles = [];
    foreach ($response as $item) {
      $article = $this->toArticle($item);
      if (!empty($article)) {
        $articles[$article->id] = $article;
      }
    }
    return $articles;
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