<?php

namespace Differ\Differ;

use Differ\Parsers;

use function Differ\AstBuilder\astBuilder;

function genDiff($firstFilePath, $secondFilePath)
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


    return astBuilder($firstFileData, $secondFileData);
}
