<?php

namespace common\Helpers;

enum EnumHelpers
{
    public static function enumsToArr(array $cases): array
    {
        $result = [];
        $arrayMapResult = array_map(fn($enum) => [$enum->value => $enum->value], $cases);
        array_walk_recursive($arrayMapResult, function ($item, $key) use (&$result) {
            $result[$key] = $item;
        });
        return $result;
    }
}
