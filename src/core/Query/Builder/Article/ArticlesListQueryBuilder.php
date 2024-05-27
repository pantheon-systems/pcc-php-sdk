<?php

namespace PccPhpSdk\core\Query\Builder\Article;

use GraphQL\Actions\Query;
use GraphQL\Entities\Variable;
use \ArrayObject;

use PccPhpSdk\api\Query\ArticleSearchArgs;
use PccPhpSdk\api\Query\Enums\ContentType;
use PccPhpSdk\core\Query\GraphQLQuery;
use PccPhpSdk\core\Query\QueryInterface;

/**
 * Articles List Query Builder to get multiple articles.
 */
class ArticlesListQueryBuilder extends ArticleBaseQueryBuilder {

  /**
   * Filter variable name.
   */
  public const FILTER_VARIABLE = 'filter';

  /**
   * Filter inputs for querying articles.
   *
   * @var ArticleFilterInput|null
   */
  private ?ArticleFilterInput $filter = null;

  /**
   * {@inheritDoc}
   */
  public function build(): QueryInterface {
    $query = new Query('articles', $this->getQueryArgs());
    $query->use(...$this->fields);
    $parsedQuery = $query->root()->parse();
    $variables = $this->getVariableVal();
    return new GraphQLQuery($parsedQuery, $variables);
  }

  /**
   * Set Filter inputs using ArticleSearchArgs.
   *
   * @param ArticleSearchArgs $searchArgs
   *   Article Search Args
   *
   * @return $this
   *   Return Self.
   */
  public function setFilter(ArticleSearchArgs $searchArgs): ArticlesListQueryBuilder {
    $this->filter = new ArticleFilterInput(
      $searchArgs->bodyContains,
      $searchArgs->tagContains,
      $searchArgs->titleContains,
      $searchArgs->publishStatus
    );
    return $this;
  }

  /**
   * Return Article Filter Input.
   *
   * @return ArticleFilterInput
   *   Filter inputs for querying articles.
   */
  public function getFilter(): ArticleFilterInput {
    return $this->filter;
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
   * Get Variable Definition for GraphQL\Actions\Query
   *
   * @return Variable[]|null
   *   Return filter variable definition or null.
   */
  private function getVariableDef(): ?array {
    $variable = null;
    if (!empty($this->filter)) {
      $variable = [
        self::FILTER_VARIABLE => new Variable(
          self::FILTER_VARIABLE,
          ArticleFilterInput::ARTICLE_FILTER_INPUT
        )
      ];
    }

    return $variable;
  }

  /**
   * Get Variable value.
   *
   * @return ArrayObject
   *   Returns Variable mapped values.
   */
  private function getVariableVal(): ArrayObject {
    $value = [];
    if (!empty($this->filter)) {
      $value[self::FILTER_VARIABLE] = [
        'body' => !empty($this->filter->bodyContains) ? ['contains' => $this->filter->bodyContains] : null,
        'title' => !empty($this->filter->titleContains) ? ['contains' => $this->filter->titleContains] : null,
        'tag' => !empty($this->filter->tagContains) ? ['contains' => $this->filter->tagContains] : null,
        'publishStatus' => !empty($this->filter->publishStatus) ? $this->filter->publishStatus : null,
      ];
    }

    return new ArrayObject($value);
  }

}
