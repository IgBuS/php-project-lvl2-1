<?php

namespace Differ\AstBuilder;

use function Funct\Collection\union;

/**
 * @param array $firstData
 * @param array $secondData
 * @return array
 */
function generateAst(array $firstData, array $secondData): array
{
    $keys = array_values(union(array_keys($firstData), array_keys($secondData)));

    $ast = array_map(function ($key) use ($firstData, $secondData) {
        if (!array_key_exists($key, $firstData)) {
            return ['name' => $key, 'value' => $secondData[$key], 'status' => 'added'];
        }

        if (!array_key_exists($key, $secondData)) {
            return ['name' => $key, 'value' => $firstData[$key], 'status' => 'deleted'];
        }

        if (is_array($firstData[$key]) && is_array($secondData[$key])) {
            return [
                'name' => $key,
                'children' => generateAst($firstData[$key], $secondData[$key]),
                'status' => 'nested'
            ];
        }

        if ($firstData[$key] !== $secondData[$key]) {
            return [
                'name' => $key, 'prevValue' => $firstData[$key],
                'curValue' => $secondData[$key], 'status' => 'changed'
            ];
        }

        if ($firstData[$key] === $secondData[$key]) {
            return ['name' => $key, 'value' => $firstData[$key], 'status' => 'unchanged'];
        }
    }, $keys);

    return $ast;
}
