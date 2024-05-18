<?php

namespace PccPhpSdk\core;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use PccPhpSdk\query\QueryInterface;

/**
 * PccClient Class.
 */
class PantheonClient {

  const PCC_TOKEN_HEADER = 'PCC-TOKEN';

  /**
   * Pantheon Client Configuration.
   *
   * @var PantheonClientConfig
   */
  private PantheonClientConfig $clientConfig;

  public function __construct(PantheonClientConfig $clientConfig) {
    $this->clientConfig = $clientConfig;
  }

  public function executeQuery(QueryInterface $query) {
    return $this->sendRequest($query->build());
  }

  public function sendRequest($body) {
    $client = new Client();
    $headers = $this->getHeaders();
    $request = new Request('POST', $this->getUrl(), $headers, $body);
    $response = $client->sendAsync($request)->wait();
    return $response->getBody();
  }

  private function getHeaders() {
    return [
      'Content-Type' => 'application/json',
      self::PCC_TOKEN_HEADER => $this->clientConfig->getSiteToken(),
    ];
  }

  private function getUrl() {
    return $this->clientConfig->getPccHost() . 'sites/' . $this->clientConfig->getSiteId() . '/query';
  }
}