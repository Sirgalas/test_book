<?php

declare(strict_types=1);

namespace common\Modules\Parser\Services\Types;



class UrlDefault implements UrlParserInterface
{
    public function getUrl(string $url): string
    {
        return $url;
    }
}