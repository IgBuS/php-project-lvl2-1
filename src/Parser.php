<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

/**
 * @param string $fileData
 * @param string $fileFormat
 * @return array
 * @throws \Exception
 */
function parse(string $fileData, string $fileFormat): array
{
    switch ($fileFormat) {
        case 'json':
            return json_decode($fileData, true);
        case 'yaml':
        case 'yml':
            return Yaml::parse($fileData);
        default:
            throw new \Exception("Format {$fileFormat} is not supported");
    }
}
