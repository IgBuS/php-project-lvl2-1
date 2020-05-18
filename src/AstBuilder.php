<?php

namespace Differ\AstBuilder;

use function Funct\Collection\union;

function astBuilder($firstData, $secondData)
{
    $keys = union(array_keys($firstData), array_keys($secondData));

    $ast = array_reduce($keys, function ($acc, $key) use ($firstData, $secondData) {
        if (!array_key_exists($key, $firstData)) {
            $acc[] = ['name' => $key, 'value' => $secondData[$key], 'status' => 'added'];
            return $acc;
        }

        if (!array_key_exists($key, $secondData)) {
            $acc[] = ['name' => $key, 'value' => $firstData[$key], 'status' => 'deleted'];
            return $acc;
        }

        if (is_array($firstData[$key]) && is_array($secondData[$key])) {
            $acc[] = [
                'name' => $key,
                'children' => astBuilder($firstData[$key], $secondData[$key]),
                'status' => 'array'
            ];
            return $acc;
        }

        if ($firstData[$key] !== $secondData[$key]) {
            $acc[] = ['name' => $key, 'prevValue' => $firstData[$key],
                      'curValue' => $secondData[$key], 'status' => 'changed'];
            return $acc;
        }

        if ($firstData[$key] === $secondData[$key]) {
            $acc[] = ['name' => $key, 'value' => $firstData[$key], 'status' => 'unchanged'];
            return $acc;
        }
    }, []);

    return $ast;
}
