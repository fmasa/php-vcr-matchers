<?php

declare(strict_types=1);

namespace Fmasa\VCR\Matchers;

use VCR\Request;

class BodyMatcherWithXpathExceptions
{

    /** @var string[] */
    private $nodesToRemove;

    /**
     * @param string[] $nodesToRemove
     */
    public function __construct(array $nodesToRemove)
    {
        $this->nodesToRemove = $nodesToRemove;
    }

    public function __invoke(Request $first, Request $second): bool
    {
        return $this->clearBody($first) === $this->clearBody($second);
    }

    private function clearBody(Request $request): string
    {
        $document = new \DOMDocument();
        $document->loadXML($request->getBody());

        $xpath = new \DOMXPath($document);

        foreach ($this->nodesToRemove as $nodeExpression) {
            $nodes = $xpath->evaluate($nodeExpression);

            foreach ($nodes as $node) {
                /** @var \DOMNode $node */
                $node->parentNode->removeChild($node);
            }
        }

        return $document->saveXML();
    }

}

