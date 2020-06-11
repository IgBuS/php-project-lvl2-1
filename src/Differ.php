<?php

namespace Differ\Differ;

use Differ\Parsers;

use function Differ\AstBuilder\generateAst;
use function Differ\Formatters\Json\formatToJson;
use function Differ\Formatters\Plain\formatToPlain;
use function Differ\Formatters\Pretty\formatToPretty;

const SUPPORTED_FORMATS = ['json', 'yaml'];

function genDiff($firstFilePath, $secondFilePath, $format)
{
    $firstFileFormat = pathinfo($firstFilePath, PATHINFO_EXTENSION);
    $secondFileFormat = pathinfo($secondFilePath, PATHINFO_EXTENSION);



    try {
        if (!in_array($firstFileFormat, SUPPORTED_FORMATS) || !in_array($secondFileFormat, SUPPORTED_FORMATS)) {
            throw new \Exception("Wrong format or missing one of the files");
        }
    } catch (\Exception $diffError) {
        return $diffError->getMessage();
    }

    $firstFileData = Parsers\formatParser($firstFilePath, $firstFileFormat);
    $secondFileData = Parsers\formatParser($secondFilePath, $secondFileFormat);

    $diffAst = generateAst($firstFileData, $secondFileData);

    if ($format === 'json') {
        $renderedDiff = formatToJson($diffAst);
    } elseif ($format === 'plain') {
        $renderedDiff = formatToPlain($diffAst);
    } else {
        $renderedDiff = formatToPretty($diffAst);
    }

    return $renderedDiff;
}
