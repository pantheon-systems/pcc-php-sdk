<?php

namespace PccPhpSdk\api\Response\Builder;

use PccPhpSdk\api\Response\Article;
use PccPhpSdk\api\Response\PaginatedArticles;
use PccPhpSdk\core\Entity\Article as ArticleEntity;
use PccPhpSdk\core\Entity\ArticlesList;

/**
 * Response builder class.
 * Provides static methods to convert internal Entities to Response objects.
 */
class ResponseBuilder {

  /**
   * Cast to Article Response.
   *
   * @param ArticleEntity $entity
   *   Corresponding Article Entity.
   *
   * @return Article
   *   Article Response object.
   */
  public static function toArticleResponse(ArticleEntity $entity): Article {
    $response = null;
    if (!empty($entity->id)) {
      $response = new Article();
      $response->id = $entity->id;
      $response->slug = $entity->slug;
      $response->title = $entity->title;
      $response->siteId = $entity->siteId;
      $response->content = $entity->content;
      $response->snippet  = $entity->snippet;
      $response->tags = $entity->tags;
      $response->publishedDate = $entity->publishedDate;
      $response->updatedAt = $entity->updatedAt;
    }

    return $response;
  }

  /**
   * Cast to Paginated Articles List.
   *
   * @param ArticlesList $articlesList
   *   Corresponding ArticlesList Entity.
   *
   * @return PaginatedArticles
   *   PaginatedArticles Response Object.
   */
  public static function toPaginatedArticles(ArticlesList $articlesList): PaginatedArticles {
    $response = new PaginatedArticles();
    foreach ($articlesList as $articleEntity) {
      $response->articles[] = self::toArticleResponse($articleEntity);
    }
    $response->total = count($articlesList);
    return $response;
  }

}
