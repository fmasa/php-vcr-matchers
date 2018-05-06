# Additional request matchers for PHP-VCR

## BodyMatcherWithXpathExceptions
Useful for matching XML requests with variable tags (such as nonce, or request time).

### Usage

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
