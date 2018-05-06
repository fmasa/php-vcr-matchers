<?php

declare(strict_types=1);

namespace Fmasa\VCR\Matchers;

use VCR\Request;

class QueryMatcherWithIgnoredParameters
{

    /** @var string[] */
    private $ignoredQueryParameters;

    /**
     * @param string[] $ignoredQueryParameters
     */
    public function __construct(array $ignoredQueryParameters)
    {
        $this->ignoredQueryParameters = $ignoredQueryParameters;
    }

    public function __invoke(Request $first, Request $second)
    {
        parse_str($first->getQuery() ?? '', $firstQuery);
        parse_str($second->getQuery() ?? '', $secondQuery);

        foreach ($this->ignoredQueryParameters as $parameter) {
            if (array_key_exists($parameter, $firstQuery)) {
                unset($firstQuery[$parameter]);
            }

            if (array_key_exists($parameter, $secondQuery)) {
                unset($secondQuery[$parameter]);
            }
        }

        ksort($firstQuery);
        ksort($secondQuery);

        return $firstQuery === $secondQuery;
    }

}
