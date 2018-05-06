<?php

declare(strict_types=1);

namespace Fmasa\VCR\Matchers;

use PHPUnit\Framework\TestCase;
use VCR\Request;

final class BodyMatcherWithXpathExceptionsTest extends TestCase
{

    /**
     * @dataProvider successfulMatchesProvider
     */
    public function testSingleExceptionFiltersCorrectNode(
        string $firstBody,
        string $secondBody,
        BodyMatcherWithXpathExceptions $matcher,
        string $descripion
    ) {
        $first = $this->requestWithBody($firstBody);
        $second = $this->requestWithBody($secondBody);

        $this->assertTrue($matcher($first, $second), $descripion);
    }

    public function successfulMatchesProvider(): array
    {
        return [
            [
                '<parent><node>1</node><different-node>123</different-node></parent>',
                '<parent><node>1</node><different-node>345</different-node></parent>',
                new BodyMatcherWithXpathExceptions(['/parent/different-node']),
                'matcher with <different-node> exception nodes matches requests',
            ],
            [
                '<parent><node>1</node><different-node>123</different-node></parent>',
                '<parent><node>2</node><different-node>345</different-node></parent>',
                new BodyMatcherWithXpathExceptions([
                    '/parent/different-node',
                    '/parent/node',
                ]),
                'matcher with <node> and <different-node> exceptions matches requests',
            ],
        ];
    }

    private function requestWithBody(string $body): Request
    {
        $request = new Request('POST', 'https://localhost');
        $request->setBody('<?xml version="1.0" encoding="UTF-8"?>' . $body);

        return $request;
    }

}
