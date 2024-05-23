<?php

namespace PccPhpSdk\api\query\Enums;

enum ContentType: string {
  case TEXT_MARKDOWN = 'TEXT_MARKDOWN';
  case TREE_PANTHEON = 'TREE_PANTHEON';
  case TREE_PANTHEON_V2 = 'TREE_PANTHEON_V2';
}
