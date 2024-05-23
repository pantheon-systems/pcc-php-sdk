<?php

namespace PccPhpSdk\api\response;

/**
 * Class PaginatedArticles
 *
 * Response Object containing articles and result summary.
 */
class PaginatedArticles {

  /**
   * Array of articles.
   *
   * @var Article[] $articles
   */
  public array $articles;

  /**
   * Total number of articles.
   *
   * @var int $total
   */
  public int $total;

  /**
   * Articles count per page.
   *
   * @var int $perPageCount
   */
  public int $perPageCount;

  /**
   * Current page number, starting from 1.
   *
   * @var int $currentPage
   */
  public int $currentPage;

  /**
   * Offset
   *
   * @var int $offset
   */
  public int $offset;

  /**
   * Limit
   *
   * @var int $limit
   */
  public int $limit;

}