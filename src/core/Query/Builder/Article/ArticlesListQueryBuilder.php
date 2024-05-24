<?php

namespace PccPhpSdk\core\Query\Builder\Article;

use GraphQL\Actions\Query;
use PccPhpSdk\api\Query\Enums\ContentType;
use PccPhpSdk\core\Query\GraphQLQuery;
use PccPhpSdk\core\Query\QueryInterface;

/**
 * Articles List Query Builder to get multiple articles.
 */
class ArticlesListQueryBuilder extends ArticleBaseQueryBuilder {

  /**
   * {@inheritDoc}
   */
  public function build(): QueryInterface {
    $query = new Query('articles', ['contentType' => ContentType::TREE_PANTHEON_V2]);
    $query->use(...$this->fields);
    $parsedQuery = $query->root()->parse();

    return new GraphQLQuery($parsedQuery);
  }

}
