<?php

namespace common\Modules\Parser\Services\Types;

interface UrlParserInterface
{
    public function getDataFromUrl(string $url): string;

}