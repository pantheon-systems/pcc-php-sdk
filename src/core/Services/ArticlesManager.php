<?php

namespace PccPhpSdk\core\Services;

use PccPhpSdk\api\Query\ArticleQueryArgs;
use PccPhpSdk\api\Query\ArticleSearchArgs;
use PccPhpSdk\core\Entity\Article;
use PccPhpSdk\core\Entity\ArticlesList;
use PccPhpSdk\core\Entity\Loader\ArticleLoader;
use PccPhpSdk\core\Entity\Loader\ArticleLoaderInterface;
use PccPhpSdk\core\PccClient;

/**
 * Articles Manager service.
 */
class ArticlesManager {

  /**
   * Article Loader.
   *
   * @var \PccPhpSdk\core\Entity\ArticleLoaderInterface
   */
  protected ArticleLoaderInterface $articleLoader;

  /**
   * Constructor for Content API.
   *
   * @param \PccPhpSdk\core\PccClient $pccClient
   *   Preconfigured PccClient.
   */
  public function __construct(PccClient $pccClient) {
    $this->articleLoader = new ArticleLoader($pccClient);
  }

  /**
   * Get Articles based on Query & Search Arguments.
   *
   * @param array $fields
   *   The Article fields.
   * @param \PccPhpSdk\api\Query\ArticleSearchArgs|null $args
   *   Search Arguments.
   *
   * @return \PccPhpSdk\core\Entity\ArticlesList
   *   ArticlesList containing matching articles.
   */
  public function getArticles(array $fields, ?ArticleQueryArgs $queryArgs = NULL, ?ArticleSearchArgs $searchArgs = NULL): ArticlesList {
    return $this->articleLoader->loadAll($fields, NULL, $searchArgs);
  }

  /**
   * Get Article by ID.
   *
   * @param array $fields
   *   The Article fields.
   * @param string $id
   *   Article ID.
   *
   * @return \PccPhpSdk\core\Entity\Article|null
   *   Article Entity.
   */
  public function getArticleById(array $fields, string $id): ?Article {
    return $this->articleLoader->loadById($fields, $id);
  }

  /**
   * Get Article bu slug.
   *
   * @param array $fields
   *   The Article fields.
   * @param string $slug
   *   Article slug.
   *
   * @return \PccPhpSdk\core\Entity\Article|null
   *   Article Entity.
   */
  public function getArticleBySlug(array $fields, string $slug): ?Article {
    return $this->articleLoader->loadBySlug($fields, $slug);
  }

}
