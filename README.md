# PCC PHP SDK | PCC Integration

### Create Panthoen Client

```php
    $pantheonClientConfig = new PantheonClientConfig(
          '--site-id-here--',
          '--site-token-here--'
        );
    $pantheonClient = new PantheonClient($pantheonClientConfig);
```


### Getting all articles

```php
    $contentApi = new ContentApi($pantheonClient);
    $content = $contentApi->getAllArticles();
```
