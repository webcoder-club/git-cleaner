# Git cleaner

```bash
composer install
php main.php
```

## Usage Example
```php
$app = new GitCleaner();

$app->removeUnusedBranches();

$app->notify(
    function ($branch) {
        /** @var GitRef $branch */
        echo $branch->getRefName() . PHP_EOL;
    }
);
```

## Run tests
```bash
./vendor/bin/phpunit tests
```