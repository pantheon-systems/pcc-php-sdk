<?php

namespace PccPhpSdk\core\Entity\Loader;

use PccPhpSdk\api\Query\Enums\PublishingLevel;
use PccPhpSdk\api\Query\ArticleQueryArgs;
use PccPhpSdk\api\Query\ArticleSearchArgs;
use PccPhpSdk\core\Entity\Article;
use PccPhpSdk\core\Entity\ArticlesList;
use PccPhpSdk\core\PccClient;
use PccPhpSdk\core\Query\Builder\Article\ArticleQueryBuilder;
use PccPhpSdk\core\Query\Builder\Article\ArticlesListQueryBuilder;
use PccPhpSdk\core\Query\QueryInterface;

/**
 * Article Loader.
 */
class ArticleLoader implements ArticleLoaderInterface {

  /**
   * PccClient.
   *
   * @var \PccPhpSdk\core\PccClient
   */
  protected PccClient $pccClient;

  /**
   * Constructor for Content API.
   *
   * @param \PccPhpSdk\core\PccClient $pccClient
   *   Preconfigured PccClient.
   */
  public function __construct(PccClient $pccClient) {
    $this->pccClient = $pccClient;
  }

  /**
   * {@inheritDoc}
   */
  public function loadById(string $id, array $fields = [], PublishingLevel $publishingLevel = PublishingLevel::PRODUCTION): ?Article {
    $queryBuilder = new ArticleQueryBuilder();
    $queryBuilder->addFields($this->getFields($fields));
    $queryBuilder->filterById($id);
    $queryBuilder->setPublishingLevel($publishingLevel);

    $query = $queryBuilder->build();
    $response = $this->sendRequest($query);
    $response = $response['article'] ?: NULL;
    return !empty($response) ? $this->toArticle($fields, $response) : NULL;
  }

  /**
   * {@inheritDoc}
   */
  public function loadBySlug(string $slug, array $fields = [], PublishingLevel $publishingLevel = PublishingLevel::PRODUCTION): ?Article {
    $queryBuilder = new ArticleQueryBuilder();
    $queryBuilder->addFields($this->getFields($fields));
    $queryBuilder->filterBySlug($slug);
    $queryBuilder->setPublishingLevel($publishingLevel);

    $query = $queryBuilder->build();
    $response = $this->sendRequest($query);

    $response = $response['article'] ?? NULL;
    return !empty($response) ? $this->toArticle($fields, $response) : NULL;
  }

  /**
   * {@inheritDoc}
   */
  public function loadAll(?ArticleQueryArgs $queryArgs, ?ArticleSearchArgs $searchArgs, array $fields = []): ArticlesList {
    $queryBuilder = new ArticlesListQueryBuilder();
    $queryBuilder->addFields($this->getFields($fields));
    if ($searchArgs) {
      $queryBuilder->setFilter($searchArgs);
    }
    if ($queryArgs) {
      $queryBuilder->setQueryArgs($queryArgs);
    }
    $query = $queryBuilder->build();
    $response = $this->sendRequest($query);
    $articles = $response['articles'] ?? [];
    $articles_list = $this->toArticlesList($fields, $articles);

    if (!empty($response['total'])) {
      $articles_list->addTotalArticlesCount($response['total']);
    }
    if (!empty($response['cursor'])) {
      $articles_list->addPageCursor($response['cursor']);
    }
    return $articles_list;
  }

  /**
   * Send Request with query.
   *
   * @param \PccPhpSdk\core\Query\QueryInterface $query
   *   Query for the request body.
   *
   * @return array
   *   Response data as array.
   */
  private function sendRequest(QueryInterface $query): array {
    $response = $this->pccClient->executeQuery($query);
    $jsonResponse = json_decode($response, TRUE);

    if ($jsonResponse === NULL) {
      throw new \Exception("Failed to parse JSON response.");
    }
    if (!isset($jsonResponse['data']) || !is_array($jsonResponse['data'])) {
      throw new \Exception("Invalid JSON response structure.");
    }

    $result = [];

    if (!empty($jsonResponse)) {
      if (!empty($jsonResponse['data']['article'])) {
        $result['article'] = $jsonResponse['data']['article'];
      }
      if (!empty($jsonResponse['data']['articles'])) {
        $result['articles'] = $jsonResponse['data']['articles'];
      }
      if (!empty($jsonResponse['extensions']['pagination']['total'])) {
        $result['total'] = $jsonResponse['extensions']['pagination']['total'];
      }
      if (!empty($jsonResponse['extensions']['pagination']['cursor'])) {
        $result['cursor'] = $jsonResponse['extensions']['pagination']['cursor'];
      }
    }
    return $result;
  }

  /**
   * Parse response to get ArticlesList.
   *
   * @param array $fields
   *   The article fields.
   * @param array $data
   *   Response data.
   *
   * @return \PccPhpSdk\core\Entity\ArticlesList
   *   ArticlesList entity.
   */
  private function toArticlesList(array $fields, array $data): ArticlesList {
    $articlesList = new ArticlesList();
    foreach ($data as $article) {
      $articleEntity = $this->toArticle($fields, $article);
      if ($articleEntity instanceof Article) {
        $articlesList->addArticle($articleEntity);
      }
    }

    return $articlesList;
  }

  /**
   * Parse response data to get Article.
   *
   * @param array $fields
   *   The article fields.
   * @param array $data
   *   Response data.
   *
   * @return \PccPhpSdk\core\Entity\Article|null
   *   Article entity or null.
   */
  private function toArticle(array $fields, array $data): ?Article {
    if (empty($data)) {
      return NULL;
    }

    $article = new Article();
    foreach ($this->getFields($fields) as $field) {
      switch ($field) {
        case 'tags':
          $article->{$field} = $data[$field] ?: [];
          break;

        case 'content':
        case 'snippet':
          $article->{$field} = $data[$field] ? $this->parseMarkdownToHtml($data[$field]) : '';
          break;

        default:
          $article->{$field} = $data[$field] ?? '';
      }
    }
    return $article;
  }

  /**
   * Convert markdown format to html.
   *
   * @param string $content
   *   The markdown string.
   *
   * @return string
   *   Returns the html string.
   */
  private function parseMarkdownToHtml(string $content): string {
    // Replace all occurrences of the pattern `{#h\..*}\n` with `\n`.
    $pattern = '/{#h\..*}\n/';
    $content = preg_replace($pattern, "\n", $content);
    $parsedown = new \Parsedown();
    return $parsedown->text($content);
  }

  /**
   * Get default article fields.
   *
   * @param array $fields
   *   The Article fields.
   *
   * @return string[]
   *   Array of fields.
   */
  protected function getFields(array $fields = []): array {
    if (!empty($fields)) {
      return $fields;
    }

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
