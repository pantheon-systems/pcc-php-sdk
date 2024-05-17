<?php

namespace PccPhpSdk;

/**
 * PccClient Class.
 */
class PccClient {

  /**
   * The site ID.
   *
   * @var string
   */
  private $siteId;

  /**
   * The site token.
   *
   * @var string
   */
  private $siteToken;

  /**
   * Constructor
   *
   * @param string $siteId
   *   Site ID.
   * @param string $siteToken
   *   Site Token.
   */
  public function __construct($siteId, $siteToken) {
    $this->siteId = $siteId;
    $this->siteToken = $siteToken;
  }

  public function getAllArticles() {

  }
}