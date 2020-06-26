<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function parse($fileData, $fileFormat)
{
    switch ($fileFormat) {
        case 'json':
            return json_decode($fileData, true);
        case 'yaml':
            return Yaml::parse($fileData);
        default:
            throw new \Exception("Format {$fileFormat} is not supported");
    }
}
