<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function formatParser($filePath, $fileFormat)
{
    if ($fileFormat == 'json') {
        $jsonData = file_get_contents($filePath);
        return json_decode($jsonData, true);
    } else {
        return Yaml::parseFile($filePath);
    }
}
