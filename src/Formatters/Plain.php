<?php

namespace Differ\Formatters\Plain;

use function Funct\Collection\flattenAll;
use function Funct\Collection\compact;

/**
 * @param array $ast
 * @return string
 */
function formatToPlain(array $ast): string
{
    $formattedElements = formatElementToPlain($ast);
    $result = compact(flattenAll($formattedElements));

    return implode("\n", $result);
}

/**
 * @param array $ast
 * @param string $path
 * @return array
 */
function formatElementToPlain(array $ast, string $path = ''): array
{
    $result = array_map(function ($astElement) use ($path) {

        $path = $path === '' ? $path = "{$astElement['name']}" : $path = "{$path}.{$astElement['name']}";

        switch ($astElement['status']) {
            case 'nested':
                $element = formatElementToPlain($astElement['children'], "{$path}");
                break;
            case 'added':
                $value = getProperValue($astElement['value']);
                $element = "Property '{$path}' was added with value: '{$value}'";
                break;
            case 'changed':
                $prevValue = getProperValue($astElement['prevValue']);
                $curValue = getProperValue($astElement['curValue']);
                $element = "Property '{$path}' was changed. From '{$prevValue}' to '{$curValue}'";
                break;
            case 'deleted':
                $element = "Property '{$path}' was removed";
                break;
            default:
                return null;
        }

        return $element;
    }, $ast);


    return $result;
}

/**
 * @param mixed $value
 * @return string
 */
function getProperValue($value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    } elseif (is_array($value)) {
        return 'complex value';
    }

    return $value;
}
