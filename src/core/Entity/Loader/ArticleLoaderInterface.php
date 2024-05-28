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
   * @param array $fields
   *   The Article fields.
   * @param string $id
   *   Article ID.
   *
   * @return \PccPhpSdk\core\Entity\Article|null
   *   Article Entity or null.
   */
  public function loadById(array $fields, string $id): ?Article;

  /**
   * Load Article by slug.
   *
   * @param array $fields
   *   The Article fields.
   * @param string $slug
   *   Article slug.
   *
   * @return \PccPhpSdk\core\Entity\Article|null
   *   Article or null.
   */
  public function loadBySlug(array $fields, string $slug): ?Article;

  /**
   * Load All Articles based on Query and Search args.
   *
   * @param array $fields
   *   The Article fields.
   * @param \PccPhpSdk\api\Query\ArticleQueryArgs|null $queryArgs
   *   Article Query Args.
   * @param \PccPhpSdk\api\Query\ArticleSearchArgs|null $searchArgs
   *   Article Search Args.
   *
   * @return \PccPhpSdk\core\Entity\ArticlesList
   *   ArticlesList containing all articles matching the criterion.
   */
  public function loadAll(array $fields, ?ArticleQueryArgs $queryArgs, ?ArticleSearchArgs $searchArgs): ArticlesList;

}
