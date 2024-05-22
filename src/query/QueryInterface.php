<?php

namespace PccPhpSdk\query;

/**
 * Query Interface to build JSON encoded query string for the payload of API request.
 */
interface QueryInterface {

  /**
   * @return string
   *   JSON encoded query string.
   */
  public function build(): string;

}
