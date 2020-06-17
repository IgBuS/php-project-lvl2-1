<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function parse($filePath, $fileFormat)
{
    if ($fileFormat == 'json') {
        return json_decode($filePath, true);
    } else {
        return Yaml::parse($filePath);
    }
}
