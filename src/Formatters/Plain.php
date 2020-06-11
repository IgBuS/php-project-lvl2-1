<?php

namespace Differ\Formatters\Plain;

function formatToPlain($ast)
{
    return formatElementToPlain($ast);
}

function formatElementToPlain($ast, $path = '')
{
    $result = array_reduce($ast, function ($acc, $astElement) use ($path) {
        if ($path === '') {
            $path = "{$astElement['name']}";
        } else {
            $path = "{$path}.{$astElement['name']}";
        }

        switch ($astElement['status']) {
            case 'nested':
                $element = formatElementToPlain($astElement['children'], "{$path}");
                $acc[] = $element;
                break;
            case 'added':
                $value = getProperValue($astElement['value']);
                $acc[] = "Property '{$path}' was added with value: '{$value}'";
                break;
            case 'deleted':
                $acc[] = "Property '{$path}' was removed";
                break;
            case 'changed':
                $prevValue = getProperValue($astElement['prevValue']);
                $curValue = getProperValue($astElement['curValue']);
                $acc[] = "Property '{$path}' was changed. From '{$prevValue}' to '{$curValue}'";
                break;
        }

        return $acc;
    }, []);

    return implode("\n", $result);
}

function getProperValue($value)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    } elseif (is_array($value)) {
        return 'complex value';
    }

    return $value;
}
