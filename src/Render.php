<?php

namespace Differ\Render;

use function Differ\Formatters\Json\jsonFormatter;
use function Differ\Formatters\Plain\plainFormatter;
use function Differ\Formatters\Pretty\prettyFormatter;

function render($ast, $style = 'pretty')
{
    if ($style === 'json') {
        $renderedDiff = jsonFormatter($ast);
    } elseif ($style === 'plain') {
        $renderedDiff = plainFormatter($ast);
    } else {
        $renderedDiff = prettyFormatter($ast);
    }

    return $renderedDiff;
}
