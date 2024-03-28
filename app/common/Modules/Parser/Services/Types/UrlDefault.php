<?php

declare(strict_types=1);

namespace common\Modules\Parser\Services\Types;



class UrlDefault implements UrlParserInterface
{
    public function getDataFromUrl(string $url): string
    {
        return file_get_contents($url);
    }

}