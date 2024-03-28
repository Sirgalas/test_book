<?php

namespace common\Modules\Parser\Services\Decodes;

interface DecodesInterface
{
    public function decode(mixed $data): array;
}