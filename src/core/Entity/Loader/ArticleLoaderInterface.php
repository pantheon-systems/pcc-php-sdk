<?php

namespace PccPhpSdk\core\Entity\Loader;

use PccPhpSdk\core\Entity\Article;
use PccPhpSdk\core\Entity\ArticlesList;

/**
 * Article Loader Interface.
 */
interface ArticleLoaderInterface {

  /**
   * ID identifier.
   */
  public const ID = 'id';

  /**
   * Slug identifier.
   */
  public const SLUG = 'slug';


  /**
   * Load Article by ID.
   *
   * @param string $id
   *   Article ID.
   *
   * @return Article|null
   *   Article Entity or null.
   */
  public function loadById(string $id): ?Article;

  /**
   * Load Article by slug.
   *
   * @param string $slug
   *   Article slug.
   *
   * @return Article|null
   *   Article or null.
   */
  public function loadBySlug(string $slug): ?Article;

  /**
   * Load All Articles.
   *
   * @return ArticlesList
   *   ArticlesList containing all articles.
   */
  public function loadAll(): ArticlesList;

}
