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
   *  Article Loader.
   *
   * @var ArticleLoaderInterface
   */
  protected ArticleLoaderInterface $articleLoader;

  /**
   * Constructor for Content API.
   *
   * @param PccClient $pccClient
   *   Preconfigured PccClient
   */
  public function __construct(PccClient $pccClient) {
    $this->articleLoader = new ArticleLoader($pccClient);
  }

  /**
   * Get Articles based on Query & Search Arguments.
   *
   * @param ArticleSearchArgs|null $args
   *    Search Arguments.
   *
   * @return ArticlesList
   *    ArticlesList containing matching articles.
   */
  public function getArticles(?ArticleQueryArgs $queryArgs = null, ?ArticleSearchArgs $searchArgs = null): ArticlesList {
    return $this->articleLoader->loadAll($queryArgs, $searchArgs);
  }

  /**
   * Get Article by ID.
   *
   * @param string $id
   *   Article ID.
   *
   * @return Article|null
   *   Article Entity.
   */
  public function getArticleById(string $id): ?Article {
    return $this->articleLoader->loadById($id);
  }

  /**
   * Get Article bu slug.
   *
   * @param string $slug
   *   Article slug.
   *
   * @return Article|null
   *   Article Entity.
   */
  public function getArticleBySlug(string $slug): ?Article {
    return $this->articleLoader->loadBySlug($slug);
  }

}
