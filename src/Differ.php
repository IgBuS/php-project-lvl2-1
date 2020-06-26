<?php

namespace Differ\Differ;

use function Differ\AstBuilder\generateAst;
use function Differ\Formatters\Json\formatToJson;
use function Differ\Formatters\Plain\formatToPlain;
use function Differ\Formatters\Pretty\formatToPretty;
use function Differ\Parser\parse;

function genDiff($firstFilePath, $secondFilePath, $format)
{
    if (!$firstFilePath || !$secondFilePath) {
        throw new \Exception("Missing one of the files");
    }

    $firstFileFormat = pathinfo($firstFilePath, PATHINFO_EXTENSION);
    $secondFileFormat = pathinfo($secondFilePath, PATHINFO_EXTENSION);

    try {
        $firstFileData = parse(file_get_contents($firstFilePath), $firstFileFormat);
        $secondFileData = parse(file_get_contents($secondFilePath), $secondFileFormat);
    } catch (\Exception $exception) {
        return $exception->getMessage();
    }





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
