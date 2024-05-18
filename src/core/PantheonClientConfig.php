<?php

namespace PccPhpSdk\core;

/**
 * Pantheon Client Configurations.
 */
class PantheonClientConfig {

  const PCC_HOST_DEFAULT = 'https://gql.prod.pcc.pantheon.io/';

  /**
   * PCC Host
   *
   * @var string
   */
  private $pccHost;

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
   * @param string|null $pccHost
   *   Pcc Host.
   */
  public function __construct(string $siteId, string $siteToken, string $pccHost = null) {
    $this->siteId = $siteId;
    $this->siteToken = $siteToken;
    $this->pccHost = $pccHost;
  }

  public function getPccHost() : string {
    return $this->pccHost ?? self::PCC_HOST_DEFAULT;
  }

  public function getSiteId() : string {
    return $this->siteId;
  }

  public function getSiteToken() : string {
    return $this->siteToken;
  }
}
