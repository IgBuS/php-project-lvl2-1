<?php

namespace Differ\Formatters\Json;

/**
 * @param $ast
 * @return string
 * @throws \Exception
 */
function formatToJson(array $ast): string
{
    $formattedJson = json_encode($ast);

    if (!$formattedJson) {
        throw new \Exception('json Encode error');
    }

    return $formattedJson;
}
