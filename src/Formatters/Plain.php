<?php

namespace Differ\Formatters\Plain;

function plainFormatter($ast)
{
    return plainElementFormatter($ast, '');
}

function plainElementFormatter($ast, $path = '')
{
    $result = array_reduce($ast, function ($acc, $astElement) use ($path) {
        if ($path === '') {
            $path = "{$astElement['name']}";
        } else {
            $path = "{$path}.{$astElement['name']}";
        }

        if ($astElement['status'] == 'array') {
            $element = plainElementFormatter($astElement['children'], "{$path}");
            $acc[] = $element;
        }

        if ($astElement['status'] == 'added') {
            $value = valueType($astElement['value']);
            $acc[] = "Property '{$path}' was added with value: '{$value}'";
        }

        if ($astElement['status'] == 'deleted') {
            $acc[] = "Property '{$path}' was removed";
        }

        if ($astElement['status'] == 'changed') {
            $prevValue = valueType($astElement['prevValue']);
            $curValue = valueType($astElement['curValue']);
            $acc[] = "Property '{$path}' was changed. From '{$prevValue}' to '{$curValue}'";
        }

        return $acc;
    }, []);

    return implode("\n", $result);
}

function valueType($value)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    } elseif (is_array($value)) {
        return 'complex value';
    }

    return $value;
}
