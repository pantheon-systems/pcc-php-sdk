# PCC PHP SDK | PCC Integration

## Create Pcc Client

```php
    $pccClientConfig = new \PccPhpSdk\core\PccClientConfig(
          '--site-id-here--',
          '--site-token-here--'
        );
    $pccClient = new \PccPhpSdk\core\PccClient($pccClientConfig);
```

## Getting all articles
```php
    $articlesApi = new \PccPhpSdk\api\ArticlesApi($pccClient);
    $fields = ['id', 'snippet', 'slug', 'title'];
    $articles = $articlesApi->getAllArticles($fields);
```

We receive response as object of PccPhpSdk\api\Response\PaginatedArticles which can be used further.

## Searching for articles where body / tag / title contains certain string.

Articles API allows to search for articles where the field(s) (body, tag, title) contains certain string.

```php
$articlesApi = new ArticlesApi($pccClient);
$bodyContains = 'Test String';
$tagContains = 'Tag';
$titleContains = 'Sample Title';
$searchArgs = new ArticleSearchArgs(
      $bodyContains,
      $tagContains,
      $titleContains,
      PublishStatus::PUBLISHED
    );
$fields = ['id', 'snippet', 'slug', 'title'];
$paginatedArticles = $articlesApi->searchArticles($fields, new ArticleQueryArgs(), $searchArgs);
```
Here also we receive response as object of PccPhpSdk\api\Response\PaginatedArticles which can be used further.

## Getting Article By ID / Slug

Using Articles API we can also fetch the article by id or slug.

```php
$contentApi = new ArticlesApi($pccClient);
$id = 'id-goes-here';
$fields = ['id', 'snippet', 'slug', 'title'];
$article1 = $articlesApi->getArticleById($fields, $id);

$slug = 'slug-goes-here';
$article2 = $articlesApi->getArticleBySlug($fields, $slug);
```

Here the response is PccPhpSdk\api\Response\Article.
