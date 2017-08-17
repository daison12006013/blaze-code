# Route

```php
$routes = [
    [
        'prefix' => ['v1', 'v1.0'],
        'with_suffix' => true,
        'middleware' => ['auth:api'],
        'namespace' => 'App\\Http\\Controllers\\V1',
        'routes' => [
            'posts',
        ],
    ],
];
```

For more info above config, you can check the wiki.

In your `routes/api.php`,

```php
$factory = new BlazeCode\RouteFactory($routes);

$factory->register(
    new BlazeCode\Laravel\Route(),
    __DIR__.'/api'
);
```
