<?php

namespace PccPhpSdk\core\Entity;

/**
 * ArticlesList Entity.
 *
 * Entity object containing Articles.
 */
class ArticlesList {

  /**
   * Articles List as array.
   *
   * @var array $articles
   */
  public array $articles = [];

  /**
   * Construct ArticlesList entity.
   *
   * @param Article[] $articles
   *   Array of Articles.
   */
  public function __construct(array $articles = []) {
    $this->articles = $articles;
  }

  /**
   * Add an Article.
   *
   * @param Article $article
   *   Article Entity.
   *
   * @return void
   *   Nothing.
   */
  public function addArticle(Article $article): void {
    $this->articles[] = $article;
  }

}
