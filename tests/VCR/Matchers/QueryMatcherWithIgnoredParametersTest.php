<?php

declare(strict_types=1);

namespace Fmasa\VCR\Matchers;

use PHPUnit\Framework\TestCase;
use VCR\Request;

final class QueryMatcherWithIgnoredParametersTest extends TestCase
{

    /**
     * @dataProvider dataMatchingRequests
     */
    public function testMatchingRequest(
        string $firstUrl,
        string $secondUrl,
        array $ignoredParamters,
        string $description
    )
    {
        $matcher = new QueryMatcherWithIgnoredParameters($ignoredParamters);

        $first = new Request('GET', $firstUrl);
        $second = new Request('GET', $secondUrl);

        $this->assertTrue($matcher($first, $second), $description);
    }

    public function dataMatchingRequests(): array
    {
        return [
             [
                 'https://example.com:8080/?timestamp=123&id2=1&id=2&token=abc',
                 'https://example.com:8080/?timestamp=345&id=2&id2=1&token=def',
                 ['timestamp', 'token'],
                 'requests with different ignored parameters match',
             ],
            [
                'https://example.com',
                'https://example.com',
                ['timestamp', 'token'],
                'requests with empty query match',
            ],
            [
                'https://example.com/?ignored=1',
                'https://example.com',
                ['ignored'],
                'requests with ignored parameter missing in one of them match',
            ],
        ];
    }

}
