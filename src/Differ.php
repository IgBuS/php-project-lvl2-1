<?php

namespace Differ\Differ;

use Differ\Parsers;

use function Differ\AstBuilder\astBuilder;
use function Differ\Formatters\Json\jsonFormatter;
use function Differ\Formatters\Plain\plainFormatter;
use function Differ\Formatters\Pretty\prettyFormatter;

function genDiff($firstFilePath, $secondFilePath, $format)
{
    $firstFileFormat = pathinfo($firstFilePath, PATHINFO_EXTENSION);
    $secondFileFormat = pathinfo($secondFilePath, PATHINFO_EXTENSION);

    if ($firstFileFormat == 'json' && $secondFileFormat == 'json') {
        $firstFileData = Parsers\jsonParser($firstFilePath);
        $secondFileData = Parsers\jsonParser($secondFilePath);
    } elseif ($firstFileFormat == 'yaml' && $secondFileFormat == 'yaml') {
        $firstFileData = Parsers\yamlParser($firstFilePath);
        $secondFileData = Parsers\yamlParser($secondFilePath);
    } else {
        echo 'Wrong format or missing one of the file';
        die();
    }

    $diffAst = astBuilder($firstFileData, $secondFileData);

    if ($format === 'json') {
        $renderedDiff = jsonFormatter($diffAst);
    } elseif ($format === 'plain') {
        $renderedDiff = plainFormatter($diffAst);
    } else {
        $renderedDiff = prettyFormatter($diffAst);
    }

    return $renderedDiff;
}
