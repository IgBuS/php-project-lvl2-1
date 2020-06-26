<?php

namespace Differ\Differ;

use function Differ\AstBuilder\generateAst;
use function Differ\Formatters\Json\formatToJson;
use function Differ\Formatters\Plain\formatToPlain;
use function Differ\Formatters\Pretty\formatToPretty;
use function Differ\Parser\parse;

/**
 * @param string $firstFilePath
 * @param string $secondFilePath
 * @param string $format
 * @return string
 * @throws \Exception
 */
function genDiff(string $firstFilePath, string $secondFilePath, string $format): string
{
    if (!$firstFilePath || !$secondFilePath) {
        throw new \Exception("Missing one of the files");
    }

    $firstFileFormat = pathinfo($firstFilePath, PATHINFO_EXTENSION);
    $secondFileFormat = pathinfo($secondFilePath, PATHINFO_EXTENSION);

    $firstFileData = parse(file_get_contents($firstFilePath), $firstFileFormat);
    $secondFileData = parse(file_get_contents($secondFilePath), $secondFileFormat);

    $diffAst = generateAst($firstFileData, $secondFileData);

    switch ($format) {
        case 'json':
            $renderedDiff = formatToJson($diffAst);
            break;
        case 'plain':
            $renderedDiff = formatToPlain($diffAst);
            break;
        default:
            $renderedDiff = formatToPretty($diffAst);
    }

    return $renderedDiff;
}
