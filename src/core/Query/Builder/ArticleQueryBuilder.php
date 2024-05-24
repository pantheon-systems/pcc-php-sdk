<?php

namespace PccPhpSdk\core\Query\Builder;

use GraphQL\Actions\Query;
use GraphQL\Entities\Variable;
use ArrayObject;

use PccPhpSdk\api\Query\Enums\ContentType;
use PccPhpSdk\core\Entity\Loader\ArticleLoaderInterface;
use PccPhpSdk\core\Query\GraphQLQuery;
use PccPhpSdk\core\Query\QueryInterface;
class ArticleQueryBuilder implements QueryBuilderInterface {

  private array $fields = [];

  private ?string $id = null;

  private ?string $slug = null;

  public function addField(string $fieldName): QueryBuilderInterface {
    $this->fields[] = $fieldName;
    return $this;
  }

  public function addFields(array $fieldNames): QueryBuilderInterface {
    $this->fields = array_merge($this->fields, $fieldNames);
    return $this;
  }

  public function filterById(string $id): QueryBuilderInterface {
    $this->id = $id;
    return $this;
  }

  public function filterBySlug(string $slug): QueryBuilderInterface {
    $this->slug = $slug;
    return $this;
  }

  public function build(): QueryInterface {
    $query = new Query('article', $this->getQueryArgs());
    $query->use(...$this->fields);
    $parsedQuery = $query->root()->parse();
    $variables = $this->getVariableVal();
    return new GraphQLQuery($parsedQuery, $variables);
  }

  private function getQueryArgs(): array {
    $args = [
      'contentType' => ContentType::TREE_PANTHEON_V2,
    ];
    $variable = $this->getVariableDef();
    if (!empty($variable)) {
      $args = array_merge($args, $variable);
    }

    return $args;
  }

  private function getVariableVal(): \ArrayObject {
    $value = [];
    if ($this->id !== null) {
      $value[ArticleLoaderInterface::ID] = $this->id;
    }
    elseif ($this->slug !== null) {
      $value[ArticleLoaderInterface::SLUG] = $this->slug;
    }

    return new \ArrayObject($value);
  }

  private function getVariableDef(): ?array {
    $variable = null;
    if ($this->id !== null) {
      $variable = [ArticleLoaderInterface::ID => $this->buildIdVariableDef()];
    }
    else if ($this->slug !== null) {
      $variable = [ArticleLoaderInterface::SLUG => $this->buildSlugVariableDef()];
    }

    return $variable;
  }

  private function buildIdVariableDef(): Variable {
    return new Variable(ArticleLoaderInterface::ID, 'String');
  }

  private function buildSlugVariableDef(): Variable {
    return new Variable(ArticleLoaderInterface::SLUG, 'String');
  }
}