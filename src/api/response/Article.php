<?php

namespace PccPhpSdk\api\response;

/**
 * Class Article
 *
 * Response object containing Article data.
 */
class Article {

  /**
   * Article ID.
   *
   * @var string $id
   */
  public string $id;

  /**
   * Article Slug.
   *
   * @var string $slug
   */
  public string $slug;

  /**
   * Article Title.
   *
   * @var string $title
   */
  public string $title;

  /**
   * Site ID.
   *
   * @var string $siteId
   */
  public string $siteId;

  /**
   * Article Content.
   *
   * @var string $content
   */
  public string $content;

  /**
   * Article snippet.
   *
   * @var string $snippet
   */
  public string $snippet;

  /**
   * Article Tags.
   *
   * @todo Redefine exact type of Tags, id or string.
   *
   * @var array $tags
   */
  public array $tags;

  /**
   * Published Date.
   *
   * @var string $publishedDate
   */
  public string $publishedDate;

  /**
   * Updated Date.
   *
   * @var string $updatedDate
   */
  public string $updatedDate;
}