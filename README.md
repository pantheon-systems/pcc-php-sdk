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
