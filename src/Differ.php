<?php

namespace Differ\Differ;

use function Differ\AstBuilder\astBuilder;
use function Differ\Render\render;

function genDiff($firstFileData, $secondFileData, $format)
{

    $ast = astBuilder($firstFileData, $secondFileData);
    $diff = render($ast, $format);

    return $diff;
}
