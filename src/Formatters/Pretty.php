<?php

namespace Differ\Formatters\Pretty;

function prettyFormatter($ast)
{
    $renderedDiff = prettyElementFormatter($ast);

    return "{\n{$renderedDiff}\n}";
}

function prettyElementFormatter($ast, $nestingLevel = 0)
{
    $nesting = str_repeat('    ', $nestingLevel);

    $renderedDiff = array_reduce($ast, function ($acc, $astElement) use ($nesting, $nestingLevel) {
        if ($astElement['status'] == 'array') {
            $element = prettyElementFormatter($astElement['children'], $nestingLevel + 1);
            $acc[] = "{$nesting}    {$astElement['name']}: {\n{$element}\n    {$nesting}}";
        }

        if ($astElement['status'] == 'added') {
            $value = valueType($astElement['value'], $nestingLevel);
            $acc[] = " {$nesting} + {$astElement['name']}: {$value}";
        }

        if ($astElement['status'] == 'deleted') {
            $value = valueType($astElement['value'], $nestingLevel);
            $acc[] = "{$nesting}  - {$astElement['name']}: {$value}";
        }

        if ($astElement['status'] == 'changed') {
            $prevValue = valueType($astElement['prevValue'], $nestingLevel);
            $curValue = valueType($astElement['curValue'], $nestingLevel);

            $acc[] = "{$nesting}  + {$astElement['name']}: {$curValue}";
            $acc[] = "{$nesting}  - {$astElement['name']}: {$prevValue}";
        }

        if ($astElement['status'] == 'unchanged') {
            $value = valueType($astElement['value'], $nestingLevel);
            $acc[] = "{$nesting}    {$astElement['name']}: {$value}";
        }

        return $acc;
    }, []);

    $result = implode("\n", $renderedDiff);
    return "{$result}";
}

function valueType($value, $nestingLevel = 0)
{
    if (is_array($value)) {
        return arrayFormatter($value, $nestingLevel);
    }

    if (is_bool($value)) {
        return $value ? "true" : "false";
    }

    return $value;
}

function arrayFormatter($value, $nestingLevel = 0)
{
    $keys = array_keys($value);
    $nesting = str_repeat('    ', $nestingLevel + 1);

    $renderedArray = array_reduce($keys, function ($acc, $key) use ($keys, $value, $nesting) {
        $acc[] = "{$nesting}    {$key}: {$value[$key]}";
        return $acc;
    }, []);

    $result = implode("\n", $renderedArray);

    return "{\n{$result}\n{$nesting}}";
}
