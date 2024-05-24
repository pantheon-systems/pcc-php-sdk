<?php

namespace PccPhpSdk\core\Services;

use PccPhpSdk\api\Query\ArticleSearchArgs;
use PccPhpSdk\core\Entity\Article;
use PccPhpSdk\core\Entity\ArticlesList;
use PccPhpSdk\core\Entity\Loader\ArticleLoader;
use PccPhpSdk\core\Entity\Loader\ArticleLoaderInterface;
use PccPhpSdk\core\PccClient;

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

  public function getArticles(?ArticleSearchArgs $args = null): ArticlesList {
    return $this->articleLoader->loadAll();
  }

  public function getArticleById(string $id): ?Article {
    return $this->articleLoader->loadById($id);
  }

  public function getArticleBySlug(string $slug): ?Article {
    return $this->articleLoader->loadBySlug($slug);
  }

}
