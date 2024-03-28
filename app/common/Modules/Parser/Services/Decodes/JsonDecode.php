<?php

declare(strict_types=1);

namespace common\Modules\Parser\Services\Decodes;

class JsonDecode implements DecodesInterface
{

    public function decode(mixed $data): array
    {
        return json_decode($data,true);
    }
}