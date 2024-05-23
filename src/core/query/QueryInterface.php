<?php

namespace PccPhpSdk\core\query;

use PccPhpSdk\Enum\EntityType;

/**
 * Query Interface to build JSON encoded query string for the payload of API request.
 */
interface QueryInterface {

  /**
   * Converts Query to executable string.
   *
   * @return string
   *   JSON encoded query string.
   */
  public function toRequestBody(): string;

}
