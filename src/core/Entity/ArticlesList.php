<?php

namespace PccPhpSdk\core\Entity;

class ArticlesList {

  public array $articles = [];

  public function __construct(array $articles = []) {
    $this->articles = $articles;
  }

  public function addArticle(Article $article) {
    $this->articles[] = $article;
  }
}
