# Install thru Composer

```shell
composer require daison/blaze-code:"dev-master"
```

Let's use the "dev-master" version which focuses on the "master" branch itself, the development is still ongoing, you may check all versions available here [https://packagist.org/packages/daison/blaze-code](https://packagist.org/packages/daison/blaze-code) to prevent code failure.

# Blaze Code

**What is blaze code?**
- A better way to handle your `Route`, `Controllers`, `Requests` into a pleasant/maintainable/reusable code.
- Agnostic, the code itself supports a Raw or you may create your own recipe for your Framework.

**What is the most notable for the Route?**
- The route manages API versions, able to handle middlewares or any recipes you can provide.

**What makes Controllers and Requests part of this?**
- You could organize the response to decide either a `redirect` or `json`.
- You may extend an existing Framework Recipe to override the response structure or any.
- It can transform your model data using Fractal in an easy way.
- It separates the Controller and Repository Pattern.

#### Laravel:
[https://github.com/daison12006013/blaze-code/wiki/Laravel-Example](https://github.com/daison12006013/blaze-code/wiki/Laravel-Example)

#### Raw PHP:
[https://github.com/daison12006013/blaze-code/wiki/Raw-PHP](https://github.com/daison12006013/blaze-code/wiki/Raw-PHP)
