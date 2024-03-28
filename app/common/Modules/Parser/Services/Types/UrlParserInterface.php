<?php

namespace common\Modules\Parser\Services\Types;

interface UrlParserInterface
{
    public function getUrl(string $url): string;
}