<?php

namespace Differ\Differ;

use Docopt;

function genDiff($firstFileData, $secondFileData)
{
    $mergedData = array_merge($firstFileData, $secondFileData);

    $diffBuffer = [];

    foreach ($mergedData as $key => $value) {
        if (is_bool($value)) {
            if ($value === true) {
                $value = "true";
            } else {
                $value = "false";
            }
        }

        if (array_key_exists($key, $firstFileData) && array_key_exists($key, $secondFileData)) {
            if ($firstFileData[$key] === $value && $secondFileData[$key] === $value) {
                $diffBuffer[] = "      {$key}: {$value}";
            } elseif ($firstFileData[$key] !== $value && $secondFileData[$key] === $value) {
                $diffBuffer[] = "    + {$key}: {$secondFileData[$key]}";
                $diffBuffer[] = "    - {$key}: {$firstFileData[$key]}";
            }
        }

        if (!array_key_exists($key, $firstFileData)) {
            $diffBuffer[] = "    + {$key}: {$value}";
        } elseif (!array_key_exists($key, $secondFileData)) {
            $diffBuffer[] = "    - {$key}: {$value}";
        }
    }

    $generatedDiff = implode("\n", $diffBuffer);
    return "{\n{$generatedDiff}\n}";
}
