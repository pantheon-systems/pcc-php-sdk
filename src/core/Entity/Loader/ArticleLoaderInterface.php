<?php

namespace PccPhpSdk\core\Entity\Loader;

use PccPhpSdk\api\Query\ArticleQueryArgs;
use PccPhpSdk\api\Query\ArticleSearchArgs;
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
   * Load All Articles based on Query and Search args.
   *
   * @param ArticleQueryArgs|null $queryArgs
   *   Article Query Args.
   * @param ArticleSearchArgs|null $searchArgs
   *   Article Search Args.
   *
   * @return ArticlesList
   *   ArticlesList containing all articles matching the criterion.
   */
  public function loadAll(?ArticleQueryArgs $queryArgs, ?ArticleSearchArgs $searchArgs): ArticlesList;

}
