# Additional request matchers for PHP-VCR

## Installation
The best way to install fmasa/php-vcr-matchers is is using [Composer](https://getcomposer.org/):

```bash
composer require fmasa/php-vcr-matchers
```

## Avialable matchers

### BodyMatcherWithXpathExceptions

Tags matching XPath expression are ignored for comparison

Useful for matching XML requests with variable tags (such as nonce, or request time).

#### Usage

```php
\VCR\VCR::configure()
    ->addRequestMatcher(
        'body',
        new \Fmasa\VCR\Matchers\BodyMatcherWithXpathExceptions([
            '//*[local-name() = "Nonce"]',
            '//*[local-name() = "Created"]',
        ])
    );
```

This will match request even when &lt;Nonce&gt; and &lt;Created&gt; tags do not match those in recorded request.

### QueryMatcherWithIgnoredParameters

Query parameters with specified names are ignored for comparison.

Useful for variable query parameters like timestamp or session ID.

#### Usage

```php
\VCR\VCR::configure()
    ->addRequestMatcher(
        'query',
        new \Fmasa\VCR\Matchers\QueryMatcherWithIgnoredParameters([
            'timestamp',
        ])
    )
```

This will match request even when timestamp parameter values are different.
