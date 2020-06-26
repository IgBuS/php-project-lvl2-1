<?php

namespace Differ\Formatters\Pretty;

/**
 * @param array $ast
 * @return string
 */
function formatToPretty(array $ast): string
{
    $renderedDiff = formatElementToPretty($ast);

    return "{\n{$renderedDiff}\n}";
}

/**
 * @param array $ast
 * @param int $nestingLevel
 * @return string
 */
function formatElementToPretty(array $ast, int $nestingLevel = 0): string
{
    $nesting = str_repeat('    ', $nestingLevel);

    $renderedDiff = array_map(function ($astElement) use ($nesting, $nestingLevel) {
        switch ($astElement['status']) {
            case 'nested':
                $element = formatElementToPretty($astElement['children'], $nestingLevel + 1);
                $currentElement = "{$nesting}    {$astElement['name']}: {\n{$element}\n    {$nesting}}";
                break;
            case 'added':
                $value = getProperValue($astElement['value'], $nestingLevel);
                $currentElement = " {$nesting} + {$astElement['name']}: {$value}";
                break;
            case 'deleted':
                $value = getProperValue($astElement['value'], $nestingLevel);
                $currentElement = "{$nesting}  - {$astElement['name']}: {$value}";
                break;
            case 'changed':
                $prevValue = getProperValue($astElement['prevValue'], $nestingLevel);
                $curValue = getProperValue($astElement['curValue'], $nestingLevel);

                $prevValueString = "{$nesting}  + {$astElement['name']}: {$curValue}";
                $curValueString = "{$nesting}  - {$astElement['name']}: {$prevValue}";
                $currentElement = "{$prevValueString}\n{$curValueString}";
                break;
            default:
                $value = getProperValue($astElement['value'], $nestingLevel);
                $currentElement = "{$nesting}    {$astElement['name']}: {$value}";
        }

        return $currentElement;
    }, $ast);

    $result = implode("\n", $renderedDiff);
    return "{$result}";
}

/**
 * @param mixed $value
 * @param int $nestingLevel
 * @return string
 */
function getProperValue($value, int $nestingLevel = 0): string
{
    if (is_array($value)) {
        return formatNestedValue($value, $nestingLevel);
    }

    if (is_bool($value)) {
        return $value ? "true" : "false";
    }

    return $value;
}

/**
 * @param mixed $value
 * @param int $nestingLevel
 * @return string
 */
function formatNestedValue($value, int $nestingLevel = 0): string
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
