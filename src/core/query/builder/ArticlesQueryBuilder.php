<?php

namespace PccPhpSdk\core\query\builder;

use GraphQL\Actions\Query;
use PccPhpSdk\api\query\Enums\ContentType;
use PccPhpSdk\core\query\GraphQLQuery;
use PccPhpSdk\core\query\QueryInterface;

class ArticlesQueryBuilder implements QueryBuilderInterface {

  private array $fields = [];

  public function addField(string $fieldName): QueryBuilderInterface {
    $this->fields[] = $fieldName;
    return $this;
  }

  public function addFields(array $fieldNames): QueryBuilderInterface {
    $this->fields = array_merge($this->fields, $fieldNames);
    return $this;
  }

  public function build(): QueryInterface {
    $query = new Query('articles', ['contentType' => ContentType::TREE_PANTHEON_V2]);
    $query->use(...$this->fields);
    $parsedQuery = $query->root()->parse();

    return new GraphQLQuery($parsedQuery);
  }

}
