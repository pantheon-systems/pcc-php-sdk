<?php

namespace PccPhpSdk\core\Query\Builder\Article;

use ArrayObject;
use GraphQL\Actions\Query;
use GraphQL\Entities\Variable;
use PccPhpSdk\api\Query\Enums\ContentType;
use PccPhpSdk\core\Entity\Loader\ArticleLoaderInterface;
use PccPhpSdk\core\Query\Builder\QueryBuilderInterface;
use PccPhpSdk\core\Query\GraphQLQuery;
use PccPhpSdk\core\Query\QueryInterface;

/**
 * Article Query Builder to get single Article.
 */
class ArticleQueryBuilder extends ArticleBaseQueryBuilder {

  /**
   * Article ID to filter.
   *
   * @var string|null $id
   */
  private ?string $id = null;

  /**
   * Article Slug to filter.
   *
   * @var string|null $slug
   */
  private ?string $slug = null;

  /**
   * Add ID for filter in the query.
   *
   * @param string $id
   *   ID value.
   *
   * @return QueryBuilderInterface
   *   Returns self.
   */
  public function filterById(string $id): QueryBuilderInterface {
    $this->id = $id;
    return $this;
  }

  /**
   * Add Slug for filter in the query.
   *
   * If ID filter already present, that will take precedence.
   *
   * @param string $slug
   *    Slug Value.
   *
   * @return QueryBuilderInterface
   *   Returns self.
   */
  public function filterBySlug(string $slug): QueryBuilderInterface {
    $this->slug = $slug;
    return $this;
  }

  /**
   * {@inheritDoc}
   */
  public function build(): QueryInterface {
    $query = new Query('article', $this->getQueryArgs());
    $query->use(...$this->fields);
    $parsedQuery = $query->root()->parse();
    $variables = $this->getVariableVal();
    return new GraphQLQuery($parsedQuery, $variables);
  }

  /**
   * Get Query Args.
   *
   * @return array
   *   Returns Query Args.
   */
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

  /**
   * Get Variable value.
   *
   * @return ArrayObject
   *   Returns Variable mapped values.
   */
  private function getVariableVal(): ArrayObject {
    $value = [];
    if ($this->id !== null) {
      $value[ArticleLoaderInterface::ID] = $this->id;
    }
    elseif ($this->slug !== null) {
      $value[ArticleLoaderInterface::SLUG] = $this->slug;
    }

    return new ArrayObject($value);
  }

  /**
   * Get Variable Definition for GraphQL\Actions\Query
   *
   * @return Variable[]|null
   *   Return ID or Slug variable definition or null.
   */
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

  /**
   * Build ID Variable Definition for the GraphQL\Actions\Query.
   *
   * @return Variable
   *   Return Variable Definition.
   */
  private function buildIdVariableDef(): Variable {
    return new Variable(ArticleLoaderInterface::ID, 'String');
  }

  /**
   * Build ID Variable Definition for the GraphQL\Actions\Query.
   *
   * @return Variable
   *   Return Variable Definition.
   */
  private function buildSlugVariableDef(): Variable {
    return new Variable(ArticleLoaderInterface::SLUG, 'String');
  }
}