<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function jsonParser($filePath)
{
    $jsonData = file_get_contents($filePath);
    return json_decode($jsonData, true);
}

function yamlParser($filePath)
{
    return Yaml::parseFile($filePath);
}
