<?php

namespace PccPhpSdk\core\Entity\Loader;

use PccPhpSdk\core\Entity\Article;
use PccPhpSdk\core\Entity\ArticlesList;

interface ArticleLoaderInterface {

  public const ID = 'id';
  public const SLUG = 'slug';

  public function loadById(string $id): ?Article;

  public function loadBySlug(string $slug): ?Article;

  public function loadAll(): ArticlesList;

}
