<?php

namespace PccPhpSdk\api\query;

use PccPhpSdk\api\query\Enums\PublishStatus;

class ArticleSearchArgs {
  private string $bodyContains;
  private string $tagContains;
  private string $titleContains;
  private PublishStatus $publishStatus;
}
