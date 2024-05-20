# PCC PHP SDK | PCC Integration

## Create Pcc Client

```php
    $pccClientConfig = new PccClientConfig(
          '--site-id-here--',
          '--site-token-here--'
        );
    $pccClient = new PccClient($pccClientConfig);
```

## Getting all articles

```php
    $contentApi = new ContentApi($pccClient);
    $content = $contentApi->getAllArticles();
```
