<?php

namespace PccPhpSdk\core\Entity\Loader;

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
  public function loadById(string $id, array $fields = []): ?Article {
    $queryBuilder = new ArticleQueryBuilder();
    $queryBuilder->addFields($this->getFields($fields));
    $queryBuilder->filterById($id);

    $query = $queryBuilder->build();

    $response = $this->sendRequest($query);
    $response = $response['article'] ?: NULL;
    return !empty($response) ? $this->toArticle($fields, $response) : NULL;
  }

  /**
   * {@inheritDoc}
   */
  public function loadBySlug(string $slug, array $fields = []): ?Article {
    $queryBuilder = new ArticleQueryBuilder();
    $queryBuilder->addFields($this->getFields($fields));
    $queryBuilder->filterBySlug($slug);

    $query = $queryBuilder->build();

    $response = $this->sendRequest($query);
    $response = $response['article'] ?: NULL;
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
    $response = $response['articles'] ?: [];
    return $this->toArticlesList($fields, $response);
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
    $result = [];
    if (!empty($jsonResponse) && !empty($jsonResponse['data'])) {
      $result = $jsonResponse['data'];
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
