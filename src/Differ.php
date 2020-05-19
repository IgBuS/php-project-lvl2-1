<?php

namespace Differ\Differ;

use Docopt;
use Differ\Parsers;

use function Differ\AstBuilder\astBuilder;
use function Differ\Render\render;

function genDiff()
{
    $doc = <<<DOC
Generate diff

Usage:
  gendiff (-h|--help)
  gendiff (-v|--version)
  gendiff [--format <fmt>] <firstFile> <secondFile>

Options:
  -h --help                     Show this screen
  -v --version                  Show version
  --format <fmt>                Report format [default: pretty]

DOC;

    $args = Docopt::handle($doc);

    $firstFilePath = realpath($args['<firstFile>']);
    $secondFilePath = realpath($args['<secondFile>']);

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

    $ast = astBuilder($firstFileData, $secondFileData);

    echo render($ast, $args['--format']);
}
